<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sembako = Category::where('slug', 'sembako')->first()->id;
        $makananRingan = Category::where('slug', 'makanan-ringan')->first()->id;
        $minuman = Category::where('slug', 'minuman')->first()->id;
        $alatTulis = Category::where('slug', 'alat-tulis')->first()->id;
        $perlengkapanRumah = Category::where('slug', 'perlengkapan-rumah')->first()->id;
        $bayi = Category::where('slug', 'produk-bayi-anak')->first()->id;
        $kesehatan = Category::where('slug', 'kesehatan-kecantikan')->first()->id;

        $products = [
            // Sembako
            ['category_id' => $sembako, 'name' => 'Beras Ramos 5kg', 'slug' => 'beras-ramos-5kg', 'sku' => 'AGR-BRS-001', 'description' => 'Beras kualitas premium 5kg', 'unit' => 'karung', 'price' => 72000],
            ['category_id' => $sembako, 'name' => 'Minyak Goreng Sania 1L', 'slug' => 'minyak-goreng-sania-1l', 'sku' => 'AGR-MNY-001', 'description' => 'Minyak goreng kemasan 1 liter', 'unit' => 'botol', 'price' => 18500],
            ['category_id' => $sembako, 'name' => 'Gula Pasir Gulaku 1kg', 'slug' => 'gula-pasir-gulaku-1kg', 'sku' => 'AGR-GLP-001', 'description' => 'Gula pasir putih 1 kg', 'unit' => 'kg', 'price' => 17500],
            ['category_id' => $sembako, 'name' => 'Tepung Terigu Segi Tiga 1kg', 'slug' => 'tepung-terigu-segi-tiga-1kg', 'sku' => 'AGR-TPG-001', 'description' => 'Tepung terigu serbaguna 1 kg', 'unit' => 'kg', 'price' => 14000],
            ['category_id' => $sembako, 'name' => 'Telur Ayam 1kg', 'slug' => 'telur-ayam-1kg', 'sku' => 'AGR-TLR-001', 'description' => 'Telur ayam negeri 1 kg', 'unit' => 'kg', 'price' => 32000],

            // Makanan Ringan
            ['category_id' => $makananRingan, 'name' => 'Chitato 68g', 'slug' => 'chitato-68g', 'sku' => 'SNK-CHT-001', 'description' => 'Keripik kentang rasa sapi panggang 68g', 'unit' => 'pcs', 'price' => 12000],
            ['category_id' => $makananRingan, 'name' => 'Tango Wafer Coklat 135g', 'slug' => 'tango-wafer-coklat-135g', 'sku' => 'SNK-TNG-001', 'description' => 'Wafer renyah isi coklat 135g', 'unit' => 'pcs', 'price' => 14500],
            ['category_id' => $makananRingan, 'name' => 'Roti Aoka Strawberry', 'slug' => 'roti-aoka-strawberry', 'sku' => 'SNK-AOK-001', 'description' => 'Roti manis isi strawberry', 'unit' => 'pcs', 'price' => 5000],
            ['category_id' => $makananRingan, 'name' => 'Kacang Garuda 150g', 'slug' => 'kacang-garuda-150g', 'sku' => 'SNK-KCG-001', 'description' => 'Kacang atom rasa original 150g', 'unit' => 'pcs', 'price' => 16500],

            // Minuman
            ['category_id' => $minuman, 'name' => 'Aqua 600ml', 'slug' => 'aqua-600ml', 'sku' => 'MIN-AQA-001', 'description' => 'Air mineral kemasan 600ml', 'unit' => 'botol', 'price' => 4500],
            ['category_id' => $minuman, 'name' => 'Teh Botol Sosro 500ml', 'slug' => 'teh-botol-sosro-500ml', 'sku' => 'MIN-SOS-001', 'description' => 'Teh siap minum kemasan 500ml', 'unit' => 'botol', 'price' => 6500],
            ['category_id' => $minuman, 'name' => 'Coca Cola 390ml', 'slug' => 'coca-cola-390ml', 'sku' => 'MIN-KOL-001', 'description' => 'Minuman soda kemasan kaleng 390ml', 'unit' => 'kaleng', 'price' => 7500],
            ['category_id' => $minuman, 'name' => 'Kopiko 3in1 10s', 'slug' => 'kopiko-3in1-10s', 'sku' => 'MIN-KOP-001', 'description' => 'Kopi instan 3 in 1 dus 10 sachet', 'unit' => 'dus', 'price' => 16000],

            // Alat Tulis
            ['category_id' => $alatTulis, 'name' => 'Buku Tulis SIDU 38 Lembar', 'slug' => 'buku-tulis-sidu-38', 'sku' => 'ATK-BKT-001', 'description' => 'Buku tulis garis 38 lembar', 'unit' => 'pcs', 'price' => 4000],
            ['category_id' => $alatTulis, 'name' => 'Pulpen Standar Hitam', 'slug' => 'pulpen-standar-hitam', 'sku' => 'ATK-PLP-001', 'description' => 'Bolpoin standar tinta hitam', 'unit' => 'pcs', 'price' => 3000],
            ['category_id' => $alatTulis, 'name' => 'Pensil 2B Faber Castell', 'slug' => 'pensil-2b-faber-castell', 'sku' => 'ATK-PNS-001', 'description' => 'Pensil 2B standar ujian', 'unit' => 'pcs', 'price' => 7000],
            ['category_id' => $alatTulis, 'name' => 'Penghapus Joyko', 'slug' => 'penghapus-joyko', 'sku' => 'ATK-PHG-001', 'description' => 'Penghapus pensil putih', 'unit' => 'pcs', 'price' => 5000],

            // Perlengkapan Rumah
            ['category_id' => $perlengkapanRumah, 'name' => 'Sabun Cuci Piring Sunlight 450ml', 'slug' => 'sabun-cuci-piring-sunlight-450ml', 'sku' => 'RTG-SCP-001', 'description' => 'Sabun pencuci piring 450ml', 'unit' => 'botol', 'price' => 22000],
            ['category_id' => $perlengkapanRumah, 'name' => 'Pembersih Lantai So Klin 800ml', 'slug' => 'pembersih-lantai-so-klin-800ml', 'sku' => 'RTG-PLT-001', 'description' => 'Pembersih lantai wangi 800ml', 'unit' => 'botol', 'price' => 18500],
            ['category_id' => $perlengkapanRumah, 'name' => 'Tisu Tiger 200s', 'slug' => 'tisu-tiger-200s', 'sku' => 'RTG-TSU-001', 'description' => 'Tisu wajah 200 lembar', 'unit' => 'pcs', 'price' => 14000],

            // Produk Bayi & Anak
            ['category_id' => $bayi, 'name' => 'Pampers Baby Dry M 46', 'slug' => 'pampers-baby-dry-m-46', 'sku' => 'BYI-PMP-001', 'description' => 'Popok bayi ukuran M isi 46', 'unit' => 'pcs', 'price' => 82000],
            ['category_id' => $bayi, 'name' => 'Susu SGM 3+ Vanila 800g', 'slug' => 'susu-sgm-3-vanila-800g', 'sku' => 'BYI-SGM-001', 'description' => 'Susu pertumbuhan vanila 800g', 'unit' => 'kaleng', 'price' => 96000],

            // Kesehatan
            ['category_id' => $kesehatan, 'name' => 'Sabun Cair Lifebuoy 450ml', 'slug' => 'sabun-cair-lifebuoy-450ml', 'sku' => 'KST-SBN-001', 'description' => 'Sabun mandi cair antibakteri 450ml', 'unit' => 'botol', 'price' => 28000],
            ['category_id' => $kesehatan, 'name' => 'Pasta Gigi Pepsodent 190g', 'slug' => 'pasta-gigi-pepsodent-190g', 'sku' => 'KST-PGT-001', 'description' => 'Pasta gigi 190g', 'unit' => 'pcs', 'price' => 16000],
            ['category_id' => $kesehatan, 'name' => 'Shampoo Pantene 250ml', 'slug' => 'shampoo-pantene-250ml', 'sku' => 'KST-SHP-001', 'description' => 'Shampoo perawatan rambut 250ml', 'unit' => 'botol', 'price' => 25000],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }

        $this->command->info('✅ '.count($products).' produk berhasil dibuat.');
    }
}
