<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all()->keyBy('code');
        $products = Product::all();

        $priceMap = [
            'AGR-BRS-001' => ['SMR' => 72000, 'SDL' => 72500, 'PLR' => 73000],
            'AGR-MNY-001' => ['SMR' => 18500, 'SDL' => 18700, 'PLR' => 19000],
            'AGR-GLP-001' => ['SMR' => 17500, 'SDL' => 17500, 'PLR' => 18000],
            'AGR-TPG-001' => ['SMR' => 14000, 'SDL' => 14200, 'PLR' => 14500],
            'AGR-TLR-001' => ['SMR' => 32000, 'SDL' => 32000, 'PLR' => 33000],

            'SNK-CHT-001' => ['SMR' => 12000, 'SDL' => 12000, 'PLR' => 12500],
            'SNK-TNG-001' => ['SMR' => 14500, 'SDL' => 14700, 'PLR' => 15000],
            'SNK-AOK-001' => ['SMR' => 5000, 'SDL' => 5000, 'PLR' => 5500],
            'SNK-KCG-001' => ['SMR' => 16500, 'SDL' => 16500, 'PLR' => 17000],

            'MIN-AQA-001' => ['SMR' => 4500, 'SDL' => 4500, 'PLR' => 5000],
            'MIN-SOS-001' => ['SMR' => 6500, 'SDL' => 6500, 'PLR' => 7000],
            'MIN-KOL-001' => ['SMR' => 7500, 'SDL' => 7500, 'PLR' => 8000],
            'MIN-KOP-001' => ['SMR' => 16000, 'SDL' => 16000, 'PLR' => 16500],

            'ATK-BKT-001' => ['SMR' => 4000, 'SDL' => 4000, 'PLR' => 4500],
            'ATK-PLP-001' => ['SMR' => 3000, 'SDL' => 3000, 'PLR' => 3500],
            'ATK-PNS-001' => ['SMR' => 7000, 'SDL' => 7000, 'PLR' => 7500],
            'ATK-PHG-001' => ['SMR' => 5000, 'SDL' => 5000, 'PLR' => 5500],

            'RTG-SCP-001' => ['SMR' => 22000, 'SDL' => 22000, 'PLR' => 23000],
            'RTG-PLT-001' => ['SMR' => 18500, 'SDL' => 18700, 'PLR' => 19000],
            'RTG-TSU-001' => ['SMR' => 14000, 'SDL' => 14000, 'PLR' => 14500],

            'BYI-PMP-001' => ['SMR' => 82000, 'SDL' => 82500, 'PLR' => 85000],
            'BYI-SGM-001' => ['SMR' => 96000, 'SDL' => 96000, 'PLR' => 98000],

            'KST-SBN-001' => ['SMR' => 28000, 'SDL' => 28000, 'PLR' => 29000],
            'KST-PGT-001' => ['SMR' => 16000, 'SDL' => 16000, 'PLR' => 16500],
            'KST-SHP-001' => ['SMR' => 25000, 'SDL' => 25000, 'PLR' => 26000],
        ];

        $count = 0;
        foreach ($products as $product) {
            if (!isset($priceMap[$product->sku])) {
                // Fallback: harga default konsisten untuk produk yang belum termapping
                $prices = [
                    'SMR' => 25000,
                    'SDL' => 25200,
                    'PLR' => 25500,
                ];
            } else {
                $prices = $priceMap[$product->sku];
            }

            foreach ($prices as $code => $price) {
                $branch = $branches[$code] ?? null;
                if (!$branch) continue;

                ProductPrice::firstOrCreate(
                    ['product_id' => $product->id, 'branch_id' => $branch->id],
                    ['price' => $price]
                );
                $count++;
            }
        }

        $this->command->info('✅ '.$count.' harga produk per cabang berhasil dibuat.');
    }
}
