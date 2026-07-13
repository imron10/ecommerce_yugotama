<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable;

    private array $categoryCache = [];
    public int $imported = 0;
    public int $updated = 0;
    public int $skipped = 0;
    public array $errors = [];
    public array $failures = [];

    /**
     * Map kolom dari CSV/Excel ke model Product.
     * Mendukung berbagai varian header Affari (Indonesia & English).
     */
    public function model(array $row)
    {
        // Detect column names (support multiple naming conventions)
        $sku = $row['sku']
            ?? $row['kode_barang']
            ?? $row['kode produk']
            ?? $row['kode']
            ?? $row['product_code']
            ?? null;

        $name = $row['name']
            ?? $row['nama_barang']
            ?? $row['nama produk']
            ?? $row['nama']
            ?? $row['product_name']
            ?? $row['product']
            ?? null;

        $categoryName = $row['category']
            ?? $row['kategori']
            ?? $row['kategori_barang']
            ?? $row['category_name']
            ?? null;

        $unit = $row['unit']
            ?? $row['satuan']
            ?? $row['uom']
            ?? 'pcs';

        $description = $row['description']
            ?? $row['deskripsi']
            ?? $row['keterangan']
            ?? null;

        if (!$sku || !$name) {
            $this->skipped++;
            return null;
        }

        $sku = trim((string) $sku);
        $name = trim((string) $name);

        // Find or create category
        $categoryId = null;
        if ($categoryName) {
            $categorySlug = Str::slug(trim($categoryName));
            if (!isset($this->categoryCache[$categorySlug])) {
                $category = Category::firstOrCreate(
                    ['slug' => $categorySlug],
                    ['name' => trim($categoryName), 'is_active' => true]
                );
                $this->categoryCache[$categorySlug] = $category->id;
            }
            $categoryId = $this->categoryCache[$categorySlug];
        }

        // Check if product exists by SKU → update
        $existingProduct = Product::where('sku', $sku)->first();
        if ($existingProduct) {
            $existingProduct->update([
                'name' => $name,
                'category_id' => $categoryId ?? $existingProduct->category_id,
                'unit' => $unit,
                'description' => $description ?? $existingProduct->description,
            ]);
            $this->updated++;
            return null; // Don't create new, already updated
        }

        // Create new product
        $this->imported++;
        return new Product([
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'sku' => $sku,
            'unit' => $unit,
            'description' => $description,
            'is_active' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:100',
            'nama_barang' => 'required_without:name|string|max:255',
            'name' => 'required_without:nama_barang|string|max:255',
        ];
    }

    public function onError(\Throwable $e)
    {
        $this->errors[] = $e->getMessage();
        $this->skipped++;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $row = $failure->row();
            $errors = implode(', ', $failure->errors());
            $this->failures[] = "Baris {$row}: {$errors}";
            $this->skipped++;
        }
    }

    public function getResultMessage(): string
    {
        $parts = [];
        if ($this->imported > 0) $parts[] = "{$this->imported} produk baru";
        if ($this->updated > 0) $parts[] = "{$this->updated} produk diperbarui";
        if ($this->skipped > 0) $parts[] = "{$this->skipped} baris dilewati";
        $msg = '✅ ' . implode(', ', $parts) . '.';
        if (count($this->failures) > 0) {
            $msg .= ' ⚠️ ' . count($this->failures) . ' error validasi.';
        }
        return $msg;
    }
}
