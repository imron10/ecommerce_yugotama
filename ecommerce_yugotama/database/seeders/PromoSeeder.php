<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $promos = [
            [
                'name' => 'Diskon Akhir Pekan Sembako',
                'slug' => 'diskon-akhir-pekan-sembako',
                'description' => 'Diskon 10% untuk semua produk sembako setiap akhir pekan',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'start_date' => (clone $now)->subDays(1),
                'end_date' => (clone $now)->addDays(6),
                'is_active' => true,
                'products' => ['AGR-BRS-001', 'AGR-MNY-001', 'AGR-GLP-001', 'AGR-TPG-001', 'AGR-TLR-001'],
            ],
            [
                'name' => 'Promo Jajanan Murah',
                'slug' => 'promo-jajanan-murah',
                'description' => 'Harga spesial untuk makanan ringan pilihan',
                'discount_type' => 'nominal',
                'discount_value' => 2000,
                'start_date' => (clone $now)->subDays(5),
                'end_date' => (clone $now)->addDays(9),
                'is_active' => true,
                'products' => ['SNK-CHT-001', 'SNK-TNG-001', 'SNK-KCG-001'],
            ],
            [
                'name' => 'Promo Hemat Minuman',
                'slug' => 'promo-hemat-minuman',
                'description' => 'Harga spesial Rp5.000 untuk Aqua & Teh Botol',
                'discount_type' => 'fixed_price',
                'discount_value' => 5000,
                'start_date' => (clone $now)->subDays(3),
                'end_date' => (clone $now)->addDays(4),
                'is_active' => true,
                'products' => ['MIN-AQA-001', 'MIN-SOS-001'],
            ],
            [
                'name' => 'Promo Belanja Bayi',
                'slug' => 'promo-belanja-bayi',
                'description' => 'Diskon 15% untuk popok dan susu bayi',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'start_date' => (clone $now)->addDays(10),
                'end_date' => (clone $now)->addDays(24),
                'is_active' => true,
                'products' => ['BYI-PMP-001', 'BYI-SGM-001'],
            ],
            [
                'name' => 'Promo Spesial Lebaran',
                'slug' => 'promo-spesial-lebaran',
                'description' => 'Promo persiapan lebaran untuk bulan depan',
                'discount_type' => 'percentage',
                'discount_value' => 8,
                'start_date' => (clone $now)->addDays(30),
                'end_date' => (clone $now)->addDays(60),
                'is_active' => false,
                'products' => ['AGR-BRS-001', 'AGR-MNY-001', 'AGR-GLP-001', 'MIN-SOS-001', 'KST-SBN-001'],
            ],
        ];

        foreach ($promos as $promoData) {
            $productSkus = $promoData['products'];
            unset($promoData['products']);

            $promo = Promo::firstOrCreate(
                ['slug' => $promoData['slug']],
                $promoData
            );

            $products = Product::whereIn('sku', $productSkus)->get();
            foreach ($products as $product) {
                $pivotData = [];
                if ($promoData['discount_type'] === 'fixed_price') {
                    $pivotData['promo_price'] = $promoData['discount_value'];
                }
                $promo->products()->syncWithoutDetaching([$product->id => $pivotData]);
            }
        }

        $this->command->info('✅ '.count($promos).' promo berhasil dibuat.');
    }
}
