<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class KatalogProduk extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $selectedCategory = null;
    public ?int $selectedBranch = null;
    public int $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => '', 'as' => 'kategori'],
        'selectedBranch' => ['except' => '', 'as' => 'cabang'],
    ];

    public function mount(): void
    {
        // Default ke cabang pertama
        if ($this->selectedBranch === null) {
            $firstBranch = Branch::where('is_active', true)->first();
            $this->selectedBranch = $firstBranch?->id;
        }
    }

    public function selectBranch(int $branchId): void
    {
        $this->selectedBranch = $branchId;
        $this->resetPage();
    }

    public function filterByCategory(?string $slug): void
    {
        $this->selectedCategory = $slug;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedCategory = null;
        $this->selectedBranch = Branch::where('is_active', true)->first()?->id;
        $this->resetPage();
    }

    public function render()
    {
        $branches = Branch::where('is_active', true)->get();
        $branchId = $this->selectedBranch;

        // Kategori dengan jumlah produk aktif
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Query produk dengan filter
        $products = Product::where('is_active', true)
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('sku', 'like', '%'.$this->search.'%');
            }))
            ->when($this->selectedCategory, fn ($q) => $q->whereHas('category', fn ($cq) => $cq->where('slug', $this->selectedCategory)))
            ->with([
                'category',
                'prices' => fn ($q) => $q->where('branch_id', $branchId),
            ])
            ->withCount(['prices' => fn ($q) => $q->where('branch_id', $branchId)])
            ->orderBy('category_id')
            ->orderBy('name')
            ->paginate($this->perPage);

        $selectedBranchName = $branches->firstWhere('id', $branchId)?->name ?? 'Pilih Cabang';

        return view('livewire.katalog-produk', [
            'products' => $products,
            'categories' => $categories,
            'branches' => $branches,
            'branchId' => $branchId,
            'selectedBranchName' => $selectedBranchName,
        ]);
    }
}
