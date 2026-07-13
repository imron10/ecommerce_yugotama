<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@yugotama.com')->first();
        $buyer = User::where('email', 'test@example.com')->first();
        $branchSmr = Branch::where('code', 'SMR')->first();
        $branchSdl = Branch::where('code', 'SDL')->first();

        if (!$admin || !$buyer || !$branchSmr) {
            $this->command->warn('⚠️ Data referensi belum lengkap. Lewati OrderSeeder.');
            return;
        }

        $products = Product::with('prices')->get()->keyBy('sku');

        $now = Carbon::now();

        $orders = [
            // Order 1: Lunas + Selesai
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSmr->id,
                'status' => 'delivered',
                'payment_method' => 'nontunai',
                'payment_status' => 'verified',
                'delivery_address' => 'Jl. P. Diponegoro No. 100, Samarinda',
                'delivery_courier' => 'JNE',
                'delivery_tracking' => 'JNE0012345678',
                'created_at' => (clone $now)->subDays(5),
                'verified_at' => (clone $now)->subDays(4),
                'shipped_at' => (clone $now)->subDays(3),
                'delivered_at' => (clone $now)->subDays(2),
                'items' => [
                    ['sku' => 'AGR-BRS-001', 'qty' => 2, 'price' => 72000],
                    ['sku' => 'AGR-MNY-001', 'qty' => 3, 'price' => 18500],
                    ['sku' => 'SNK-CHT-001', 'qty' => 5, 'price' => 12000],
                ],
            ],
            // Order 2: Menunggu Verifikasi (dengan dummy proof_of_payment)
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSmr->id,
                'status' => 'pending',
                'payment_method' => 'nontunai',
                'payment_status' => 'pending',
                'proof_of_payment' => 'proofs/demo-bukti-transfer.jpg',
                'delivery_address' => 'Jl. P. Diponegoro No. 100, Samarinda',
                'created_at' => (clone $now)->subHours(6),
                'items' => [
                    ['sku' => 'MIN-AQA-001', 'qty' => 12, 'price' => 4500],
                    ['sku' => 'MIN-SOS-001', 'qty' => 6, 'price' => 6500],
                ],
            ],
            // Order 3: Diproses
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSdl->id,
                'status' => 'processing',
                'payment_method' => 'nontunai',
                'payment_status' => 'verified',
                'delivery_address' => 'Jl. HM. Ardiansyah No. 50, Samarinda Seberang',
                'delivery_courier' => 'SiCepat',
                'created_at' => (clone $now)->subDays(2),
                'verified_at' => (clone $now)->subDays(1),
                'items' => [
                    ['sku' => 'ATK-BKT-001', 'qty' => 10, 'price' => 4000],
                    ['sku' => 'ATK-PLP-001', 'qty' => 20, 'price' => 3000],
                    ['sku' => 'ATK-PNS-001', 'qty' => 10, 'price' => 7000],
                    ['sku' => 'BYI-PMP-001', 'qty' => 2, 'price' => 82000],
                ],
            ],
            // Order 4: Dikirim
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSmr->id,
                'status' => 'shipped',
                'payment_method' => 'nontunai',
                'payment_status' => 'verified',
                'delivery_address' => 'Jl. P. Diponegoro No. 100, Samarinda',
                'delivery_courier' => 'J&T',
                'delivery_tracking' => 'JT0098765432',
                'created_at' => (clone $now)->subDays(3),
                'verified_at' => (clone $now)->subDays(2),
                'shipped_at' => (clone $now)->subHours(12),
                'items' => [
                    ['sku' => 'KST-SBN-001', 'qty' => 3, 'price' => 28000],
                    ['sku' => 'KST-PGT-001', 'qty' => 2, 'price' => 16000],
                    ['sku' => 'KST-SHP-001', 'qty' => 2, 'price' => 25000],
                ],
            ],
            // Order 5: Pembayaran Ditolak
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSmr->id,
                'status' => 'cancelled',
                'payment_method' => 'nontunai',
                'payment_status' => 'rejected',
                'rejection_reason' => 'Bukti transfer tidak jelas, harap upload ulang dengan foto yang lebih terang.',
                'delivery_address' => 'Jl. P. Diponegoro No. 100, Samarinda',
                'created_at' => (clone $now)->subDays(1),
                'verified_at' => (clone $now)->subHours(2),
                'verified_by' => $admin->id,
                'items' => [
                    ['sku' => 'SNK-TNG-001', 'qty' => 3, 'price' => 14500],
                    ['sku' => 'SNK-AOK-001', 'qty' => 6, 'price' => 5000],
                ],
            ],
            // Order 6: Tunai (langsung verified)
            [
                'user_id' => $buyer->id,
                'branch_id' => $branchSmr->id,
                'status' => 'processing',
                'payment_method' => 'tunai',
                'payment_status' => 'verified',
                'delivery_address' => 'Jl. P. Diponegoro No. 100, Samarinda',
                'created_at' => (clone $now)->subHours(3),
                'verified_at' => (clone $now)->subHours(2),
                'items' => [
                    ['sku' => 'AGR-GLP-001', 'qty' => 1, 'price' => 17500],
                    ['sku' => 'AGR-TPG-001', 'qty' => 2, 'price' => 14000],
                    ['sku' => 'RTG-SCP-001', 'qty' => 1, 'price' => 22000],
                    ['sku' => 'RTG-TSU-001', 'qty' => 3, 'price' => 14000],
                ],
            ],
        ];

        $orderCount = 0;
        $itemCount = 0;

        foreach ($orders as $orderData) {
            $items = $orderData['items'];
            unset($orderData['items']);

            // Calculate totals
            $subtotal = 0;
            $orderItemsData = [];
            foreach ($items as $item) {
                $product = $products[$item['sku']] ?? null;
                if (!$product) {
                    $this->command->warn("⚠️ Produk SKU {$item['sku']} tidak ditemukan, dilewati.");
                    continue;
                }

                $unitPrice = $item['price'];
                $qty = $item['qty'];
                $lineSubtotal = $unitPrice * $qty;
                $subtotal += $lineSubtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $orderData['subtotal'] = $subtotal;
            $orderData['shipping_cost'] = 10000; // flat shipping
            $orderData['discount'] = 0;
            $orderData['total'] = $subtotal + $orderData['shipping_cost'];

            // Assign verified_by if verified
            if (isset($orderData['verified_at']) && !isset($orderData['verified_by'])) {
                $orderData['verified_by'] = $admin->id;
            }

            // Generate order number
            $datePrefix = Carbon::parse($orderData['created_at'])->format('Ymd');
            $orderData['order_number'] = 'ORD-' . $datePrefix . '-' . str_pad($orderCount + 1, 4, '0', STR_PAD_LEFT);

            $order = Order::firstOrCreate(
                ['order_number' => $orderData['order_number']],
                $orderData
            );
            $orderCount++;

            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::firstOrCreate(
                    ['order_id' => $order->id, 'product_id' => $itemData['product_id']],
                    $itemData
                );
                $itemCount++;
            }
        }

        $this->command->info('✅ '.$orderCount.' pesanan dengan '.$itemCount.' item berhasil dibuat.');
    }
}
