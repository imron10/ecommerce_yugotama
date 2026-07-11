<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\KatalogProduk;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Branch selection
    $branches = \App\Models\Branch::where('is_active', true)->get();
    $selectedBranch = request()->query('cabang', $branches->first()?->id);

    $featuredProducts = Product::with([
        'category',
        'prices' => fn ($q) => $q->where('branch_id', $selectedBranch),
    ])->where('is_active', true)
        ->inRandomOrder()
        ->limit(8)
        ->get();

    $categories = Category::where('is_active', true)
        ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
        ->having('products_count', '>', 0)
        ->get();

    return view('welcome', compact('featuredProducts', 'categories', 'selectedBranch'));
});

Route::get('/produk', KatalogProduk::class)->name('produk.katalog');


Route::get('/dashboard', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('produk.katalog');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
