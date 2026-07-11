# Panduan TDD (Test-Driven Development) — E-Commerce Yugotama Mart
### Untuk Tim Magang: 3 Mahasiswa | Dipandu Dosen

Stack testing: **Pest PHP** (lebih ramah pemula dibanding PHPUnit murni, tetap kompatibel dengan Laravel)

---

## 1. Kenapa TDD Penting untuk Proyek Ini (Bukan Sekadar Formalitas)

Untuk tim mahasiswa basic, TDD punya manfaat lebih dari sekadar "praktik bagus":

1. **Test = dokumentasi hidup.** Bapak bisa baca file test untuk tahu persis apa yang sudah bekerja, tanpa harus baca semua kode.
2. **Mencegah fitur baru merusak fitur lama** — penting karena proyek ini multi-fase (Fase 0-4) dan dikerjakan bergantian oleh 3 orang.
3. **Checkpoint objektif.** "Sudah selesai" didefinisikan sebagai *"semua test terkait fase ini hijau"*, bukan opini subjektif mahasiswa.
4. Karena harga per cabang, poin loyalty, dan promo cut price melibatkan **perhitungan angka** — ini area yang paling rawan bug kalau tidak ditest, dan paling mudah ditest.

## 2. Alur Kerja TDD yang Dipakai (Sederhana: Red → Green → Refactor)

Untuk mahasiswa basic, cukup 3 langkah ini per fitur kecil:

1. **Red** — tulis test dulu untuk perilaku yang diinginkan → jalankan → **harus gagal** (karena fiturnya belum ada)
2. **Green** — tulis kode paling sederhana supaya test tadi **lolos**
3. **Refactor** — rapikan kode setelah test hijau, jalankan ulang test untuk pastikan masih hijau

> Aturan tim: **jangan menulis kode fitur sebelum ada test yang gagal untuk fitur itu.** Kalau mahasiswa kesulitan menulis test duluan, minimal tulis test **segera setelah** fitur jadi — jangan sampai fitur selesai tanpa test sama sekali.

## 3. Setup Awal (Dilakukan di Fase 0 oleh Dosen)

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

- [ ] Jalankan `php artisan test` — pastikan test default Laravel (`ExampleTest`) hijau
- [ ] Gunakan **database SQLite in-memory** untuk testing (lebih cepat, tidak mengotori database development di MAMP):
  ```env
  # .env.testing
  DB_CONNECTION=sqlite
  DB_DATABASE=:memory:
  ```

## 4. Contoh Test per Fase (Referensi untuk Mahasiswa)

### Fase 0 — Katalog & Harga per Cabang (dosen, sebagai contoh pola)

```php
// tests/Feature/ProductPriceTest.php

it('menampilkan harga produk sesuai cabang yang dipilih', function () {
    $branchA = Branch::factory()->create(['name' => 'Samarinda Kota']);
    $branchB = Branch::factory()->create(['name' => 'Palaran']);
    $product = Product::factory()->create();

    ProductPrice::factory()->create(['product_id' => $product->id, 'branch_id' => $branchA->id, 'price' => 15000]);
    ProductPrice::factory()->create(['product_id' => $product->id, 'branch_id' => $branchB->id, 'price' => 17000]);

    expect($product->priceForBranch($branchA->id))->toBe(15000);
    expect($product->priceForBranch($branchB->id))->toBe(17000);
});
```

> Pola ini yang ditiru mahasiswa untuk fitur lain: **Arrange** (siapkan data) → **Act** (panggil fungsi/method) → **Assert** (cek hasilnya sesuai harapan).

### Fase 1 — Checkout & Verifikasi Nontunai (Mahasiswa C)

```php
it('pesanan berstatus menunggu verifikasi setelah checkout nontunai', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create(['payment_method' => 'nontunai']);

    expect($order->status)->toBe('menunggu_verifikasi');
});

it('admin dapat memverifikasi pembayaran nontunai', function () {
    $order = Order::factory()->create(['status' => 'menunggu_verifikasi']);
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post("/admin/orders/{$order->id}/verifikasi");

    expect($order->fresh()->status)->toBe('diproses');
});
```

### Fase 2 — Poin Loyalty (Mahasiswa A)

```php
it('memberikan 1 poin untuk setiap kelipatan Rp100.000 belanja', function () {
    $member = Member::factory()->create(['points' => 0]);
    $order = Order::factory()->for($member)->create(['total' => 250000]);

    $member->addPointsFromOrder($order);

    expect($member->fresh()->points)->toBe(2); // 250rb = 2x kelipatan 100rb
});

it('tidak memberikan poin jika belanja di bawah Rp100.000', function () {
    $member = Member::factory()->create(['points' => 0]);
    $order = Order::factory()->for($member)->create(['total' => 75000]);

    $member->addPointsFromOrder($order);

    expect($member->fresh()->points)->toBe(0);
});
```

### Fase 3 — Promo Cut Price (Mahasiswa A)

```php
it('menampilkan harga promo saat periode promo aktif', function () {
    $product = Product::factory()->create();
    Promo::factory()->create([
        'product_id' => $product->id,
        'nama' => '5 Sip',
        'harga_promo' => 5000,
        'mulai' => now()->subHour(),
        'selesai' => now()->addHour(),
    ]);

    expect($product->hargaAktif())->toBe(5000);
});

it('kembali ke harga normal setelah periode promo berakhir', function () {
    $product = Product::factory()->create();
    Promo::factory()->create([
        'product_id' => $product->id,
        'harga_promo' => 5000,
        'mulai' => now()->subDays(2),
        'selesai' => now()->subDay(),
    ]);

    expect($product->hargaAktif())->not->toBe(5000);
});
```

### Fase 4 — Delivery & Pembatasan Area (Mahasiswa C)

```php
it('menolak checkout delivery di luar area yang didukung', function () {
    $order = Order::factory()->make(['area_pengiriman' => 'Bontang']);

    expect(fn () => $order->validasiArea())->toThrow(AreaTidakDidukungException::class);
});

it('menerapkan gratis ongkir jika belanja mencapai minimum', function () {
    $order = Order::factory()->create(['subtotal' => 150000, 'metode_kirim' => 'kurir_internal']);

    expect($order->hitungOngkir())->toBe(0);
});
```

## 5. Aturan Minimal Coverage per Fase

| Fase | Wajib Ditest |
|---|---|
| Fase 0 | Harga per cabang tampil benar, produk hasil impor Affari sesuai format |
| Fase 1 | Alur checkout, status pesanan berubah sesuai metode bayar, verifikasi admin |
| Fase 2 | Perhitungan poin, kode member unik ter-generate tanpa duplikat |
| Fase 3 | Harga promo aktif/nonaktif sesuai jadwal, tidak menimpa harga produk lain |
| Fase 4 | Validasi area pengiriman, perhitungan ongkir, perubahan status pesanan |

> **Checkpoint mingguan dosen bertambah 1 syarat:** selain fitur berjalan, mahasiswa juga wajib tunjukkan `php artisan test` hijau untuk modul terkait sebelum fase dianggap selesai.

## 6. Menjalankan Test

```bash
php artisan test                      # semua test
php artisan test --filter=ProductPrice # test spesifik
php artisan test --coverage            # butuh Xdebug/PCOV terpasang
```

- [ ] Tambahkan GitHub Actions sederhana (opsional, kalau tim sudah siap) supaya test otomatis jalan tiap kali ada push — cegah kode rusak masuk ke branch utama tanpa disadari.

## 7. Catatan untuk Mahasiswa Basic

- Tidak apa-apa kalau di awal test ditulis **setelah** kode jadi (bukan TDD murni) — yang penting kebiasaan menulis test terbentuk dulu.
- Fokus dulu test level **Feature** (menguji alur, seperti contoh di atas) — belum perlu Unit test murni yang lebih abstrak, itu bisa menyusul kalau tim sudah lebih nyaman.
- Kalau bingung menulis assertion, tanyakan ke AI dengan pola: *"saya punya fungsi X yang seharusnya melakukan Y, tolong bantu tulis test Pest untuk itu dan jelaskan tiap barisnya"* — supaya tetap belajar, bukan cuma copy-paste.
