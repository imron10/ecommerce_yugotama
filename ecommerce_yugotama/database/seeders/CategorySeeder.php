<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sembako', 'slug' => 'sembako', 'description' => 'Kebutuhan pokok sembilan bahan pokok'],
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'description' => 'Snack, cemilan, dan makanan ringan'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Minuman kemasan, sirup, dan minuman siap saji'],
            ['name' => 'Alat Tulis', 'slug' => 'alat-tulis', 'description' => 'ATK, buku, pulpen, dan perlengkapan kantor'],
            ['name' => 'Perlengkapan Rumah', 'slug' => 'perlengkapan-rumah', 'description' => 'Alat kebersihan, dapur, dan kebutuhan rumah tangga'],
            ['name' => 'Produk Bayi & Anak', 'slug' => 'produk-bayi-anak', 'description' => 'Popok, susu bayi, MPASI, dan perlengkapan anak'],
            ['name' => 'Kesehatan & Kecantikan', 'slug' => 'kesehatan-kecantikan', 'description' => 'Obat-obatan, vitamin, sabun, dan kosmetik'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('✅ '.count($categories).' kategori berhasil dibuat.');
    }
}
