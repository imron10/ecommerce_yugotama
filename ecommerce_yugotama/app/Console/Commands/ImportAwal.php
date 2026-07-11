<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportAwal extends Command
{
    protected $signature = 'app:import-awal
                            {file : Path ke file CSV yang akan diimport}
                            {--dry-run : Proses tanpa menyimpan ke database, hanya validasi}';

    protected $description = 'Import data produk dan harga dari file CSV (format: dari Affari)';

    private int $imported = 0;
    private int $skipped = 0;
    private int $errors = 0;

    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (! file_exists($filePath)) {
            $this->error("❌ File tidak ditemukan: {$filePath}");
            return Command::FAILURE;
        }

        $dryRun = $this->option('dry-run');
        $rows = $this->parseCsv($filePath);

        if (empty($rows)) {
            $this->error('❌ File CSV kosong atau tidak valid.');
            return Command::FAILURE;
        }

        $this->info("📄 Memproses ".count($rows)." baris data...");
        if ($dryRun) {
            $this->warn('⏸️  Mode DRY-RUN — tidak ada data yang disimpan.');
        }

        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        foreach ($rows as $index => $row) {
            try {
                $this->processRow($row, $dryRun);
            } catch (\Exception $e) {
                $this->errors++;
                $this->newLine();
                $this->warn("⚠️  Baris ke-".($index + 2).": {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['Status', 'Jumlah'],
            [
                ['✅ Berhasil', $this->imported],
                ['⏭️  Dilewati (sudah ada)', $this->skipped],
                ['❌ Gagal', $this->errors],
            ]
        );

        if ($dryRun) {
            return Command::SUCCESS;
        }

        $this->info("🎉 Import selesai! ".$this->imported." data baru berhasil ditambahkan.");
        return Command::SUCCESS;
    }

    private function parseCsv(string $filePath): array
    {
        $rows = [];
        $handle = fopen($filePath, 'r');

        if (! $handle) {
            return $rows;
        }

        // Baca header
        $headers = fgetcsv($handle);

        if (! $headers) {
            fclose($handle);
            return $rows;
        }

        // Bersihkan BOM dan whitespace
        $headers = array_map(fn ($h) => trim(preg_replace('/^\xEF\xBB\xBF/', '', $h)), $headers);
        $headers = array_map('strtolower', $headers);

        $expected = ['category_name', 'category_slug', 'product_sku', 'product_name',
                      'product_description', 'product_unit', 'branch_code', 'price'];

        $missing = array_diff($expected, $headers);
        if (! empty($missing)) {
            $this->error('❌ Kolom CSV tidak lengkap. Kurang: '.implode(', ', $missing));
            $this->info('   Kolom yang diharapkan: '.implode(', ', $expected));
            fclose($handle);
            return $rows;
        }

        while (($line = fgetcsv($handle)) !== false) {
            $data = array_combine($headers, $line);
            if ($data && ! empty(array_filter($data))) {
                $rows[] = $data;
            }
        }

        fclose($handle);
        return $rows;
    }

    private function processRow(array $row, bool $dryRun): void
    {
        $categoryName = trim($row['category_name']);
        $categorySlug = trim($row['category_slug']);
        $productSku   = trim($row['product_sku']);
        $productName  = trim($row['product_name']);
        $description  = trim($row['product_description'] ?? '');
        $unit         = trim($row['product_unit'] ?: 'pcs');
        $branchCode   = trim($row['branch_code']);
        $price        = str_replace(['.', ','], ['', '.'], trim($row['price']));

        // Validasi harga
        if (! is_numeric($price) || (float) $price <= 0) {
            throw new \Exception("Harga tidak valid: {$row['price']}");
        }

        // Validasi cabang
        $branch = Branch::where('code', $branchCode)->first();
        if (! $branch) {
            throw new \Exception("Cabang dengan kode '{$branchCode}' tidak ditemukan. Seed cabang dulu: php artisan db:seed --class=BranchSeeder");
        }

        if ($dryRun) {
            $this->imported++;
            return;
        }

        // 1. Cari atau buat kategori
        $category = Category::firstOrCreate(
            ['slug' => $categorySlug],
            [
                'name' => $categoryName,
                'slug' => $categorySlug,
                'description' => "Kategori {$categoryName}",
                'is_active' => true,
            ]
        );

        // 2. Cari atau buat produk
        $product = Product::firstOrCreate(
            ['sku' => $productSku],
            [
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productSku.'-'.$productName),
                'sku' => $productSku,
                'description' => $description,
                'unit' => $unit,
                'is_active' => true,
            ]
        );

        // 3. Buat harga per cabang
        $priceResult = ProductPrice::firstOrCreate(
            [
                'product_id' => $product->id,
                'branch_id' => $branch->id,
            ],
            [
                'price' => (float) $price,
            ]
        );

        if ($priceResult->wasRecentlyCreated) {
            $this->imported++;
        } else {
            $this->skipped++;
        }
    }
}
