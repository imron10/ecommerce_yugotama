# Cara Pakai Starter Blade Ini

## 1. Copy file ke project Laravel

Copy folder `resources/views/*` ke dalam project Laravel Bapak (`nama-project-ecommerce/resources/views/`).

## 2. Tambahkan routes

Buka `routes/web.php`, tambahkan:

```php
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog/cari', [HomeController::class, 'cari'])->name('katalog.cari');
Route::get('/katalog/kategori/{nama}', [HomeController::class, 'kategori'])->name('katalog.kategori');

Route::get('/keranjang', [HomeController::class, 'keranjang'])->name('keranjang.index');
Route::post('/keranjang/tambah/{id}', [HomeController::class, 'tambahKeranjang'])->name('keranjang.tambah');
Route::patch('/keranjang/update/{id}', [HomeController::class, 'updateKeranjang'])->name('keranjang.update');

Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout.proses');
Route::get('/akun', [HomeController::class, 'akun'])->name('akun.index');
```

## 3. Buat controller sederhana (contoh awal, boleh dikembangkan Mahasiswa A)

```bash
php artisan make:controller HomeController
```

Isi minimal supaya view bisa langsung dibuka (masih pakai data placeholder yang sudah ada di dalam file blade lewat `@empty`/`@forelse`):

```php
public function index()
{
    return view('home');
}

public function keranjang()
{
    return view('keranjang');
}
```

Setelah tabel produk & keranjang siap (dikerjakan Mahasiswa A), tinggal kirim data asli lewat `compact('products', 'items', ...)` — struktur blade-nya sudah menyesuaikan otomatis lewat `@forelse`, tidak perlu ubah HTML.

## 4. Pastikan Tailwind & npm sudah jalan

```bash
npm run dev
```

Kalau icon Tabler tidak muncul, pastikan koneksi internet aktif (dipanggil lewat CDN di `layouts/app.blade.php`). Kalau mau offline, install `@tabler/icons-webfont` lewat npm dan ganti link CDN dengan import lokal.

## 5. Struktur file yang disertakan

```
resources/views/
├── layouts/
│   └── app.blade.php      -> layout dasar (header html, tailwind, tabler icons)
├── home.blade.php          -> homepage + katalog produk
└── keranjang.blade.php     -> cart + checkout
```

## Catatan untuk pembagian tugas mahasiswa

- **Mahasiswa A** (backend): buat migration `products`, `categories`, `cart_items`, lalu sambungkan ke `HomeController` menggantikan data placeholder di masing-masing view.
- **Mahasiswa B** (frontend): sesuaikan style, tambahkan responsive behaviour, uji tampilan di berbagai ukuran layar HP.
- **Mahasiswa C** (integrasi): sambungkan form checkout (`checkout.proses`) ke Midtrans, dan buat logic hitung subtotal/ongkir/diskon menggantikan angka statis di `keranjang.blade.php`.
