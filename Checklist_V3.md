# Checklist Starter Project — E-Commerce Laravel (Yugomart)
### CV Yugotama Megah Abadi Retail | Tim Magang: 3 Mahasiswa

**Berdasarkan PRD E-Commerce Yugotama Mart v3.0 (13 Juli 2026)**

Stack: **Laravel + Livewire + Filament + Tailwind CSS v4 + MySQL (via MAMP)**

> **Perubahan terbaru (mengikuti PRD v3.0):** Arsitektur **dikembalikan ke 1 toko online (Yugomart), 1 admin** — konsep multi-cabang (landing terpisah per cabang, `branch_id`, harga per cabang) **dibatalkan**. Pembagian tugas mahasiswa kembali ke **per-layer teknis** (Backend, Frontend, Integrasi). Lihat Bagian 6 & 7.

---

## 0. Persiapan Awal (Dikerjakan Bersama, Hari 1)

Semua mahasiswa install tools ini di laptop masing-masing sebelum mulai:

- [ ] **PHP** ≥ 8.2 — cek dengan `php -v`
- [ ] **Composer** (package manager PHP) — https://getcomposer.org
- [ ] **Node.js** ≥ 18 & npm — cek dengan `node -v`, `npm -v`
- [ ] **MAMP** (untuk MySQL + Apache lokal, karena menggunakan MacBook) — https://www.mamp.info
      > **Info MAMP:** Default port Apache = **8888**, MySQL = **8889**. phpMyAdmin di: `http://localhost:8888/phpMyAdmin/`
      > Username MySQL: `root`, Password: `root` (default MAMP)
- [ ] **Git** + akun GitHub (untuk kolaborasi & version control tim)
- [ ] Text editor: **VS Code** + extension: PHP Intelephense, Laravel Blade Snippets, Tailwind CSS IntelliSense

**Checkpoint dosen:** pastikan ketiga mahasiswa bisa jalankan `php -v`, `composer --version`, dan `node -v` tanpa error sebelum lanjut.

---

## 1. Setup Project Laravel

> **Catatan:** Project Laravel sudah dibuat oleh dosen (Fase 0) dan di-push ke GitHub. Mahasiswa cukup clone.

```bash
git clone https://github.com/imron10/ecommerce_yugotama.git
cd ecommerce_yugotama
composer install
npm install
```

### Konfigurasi Database (MAMP)

- [ ] **Start MAMP** — buka aplikasi MAMP, klik **Start Servers** (Apache + MySQL menyala hijau)
- [ ] **Buat database** — buka `http://localhost:8888/phpMyAdmin/` → login `root` / `root` → **New** → ketik `ecommerce_yugotama` → **Create**
- [ ] **Buat file `.env`** — copy dari `.env.example`:
  ```bash
  cp .env.example .env
  ```
- [ ] Sesuaikan konfigurasi database di `.env` (wajib karena MAMP pakai port 8889 & password root):
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=8889
  DB_DATABASE=ecommerce_yugotama
  DB_USERNAME=root
  DB_PASSWORD=root
  ```
- [ ] Generate APP_KEY:
  ```bash
  php artisan key:generate
  ```
- [ ] Jalankan migrasi:
  ```bash
  php artisan migrate
  ```
- [ ] Jalankan Laravel:
  ```bash
  php artisan serve
  ```
  Buka `http://127.0.0.1:8000` — pastikan halaman Laravel muncul.

---

## 2. Install Tailwind CSS v4

```bash
npm install
npm install tailwindcss @tailwindcss/vite
```

- [ ] Di `vite.config.js`, tambahkan plugin Tailwind:
  ```js
  import { defineConfig } from 'vite';
  import tailwindcss from '@tailwindcss/vite';
  import laravel from 'laravel-vite-plugin';

  export default defineConfig({
      plugins: [
          laravel({
              input: ['resources/css/app.css', 'resources/js/app.js'],
              refresh: true,
          }),
          tailwindcss(),
      ],
  });
  ```
- [ ] Di `resources/css/app.css`, tambahkan:
  ```css
  @import "tailwindcss";
  ```
- [ ] Jalankan Vite:
  ```bash
  npm run dev
  ```
- [ ] **Test:** tambahkan class Tailwind (misal `text-3xl font-bold text-blue-600`) di `resources/views/welcome.blade.php`, refresh browser — pastikan style berubah

---

## 3. Install Livewire

```bash
composer require livewire/livewire
```

- [ ] Buat komponen test: `php artisan make:livewire Counter`
- [ ] Pasang `<livewire:counter />` di halaman welcome
- [ ] Test klik tombol — pastikan angka bertambah tanpa reload halaman

---

## 4. Install Filament (Admin Panel)

```bash
composer require filament/filament
php artisan filament:install --panels
php artisan make:filament-user
```

Saat diminta:
- **Name:** `Admin`
- **Email:** `admin@yugotama.com`
- **Password:** (buat password, misal `password123`)

- [ ] Akses panel di `http://127.0.0.1:8000/admin` — pastikan bisa login
- [ ] **Fondasi dari dosen:** Dosen sudah membuat Resource Filament untuk Produk & Kategori

> Filament akan jadi fondasi dashboard admin untuk kelola produk, member, order, dan status delivery — 1 panel untuk seluruh toko, tanpa perlu bikin UI admin manual dari nol.

---

## 4b. Struktur Database Inti (Dikerjakan Dosen di Fase 0)

Karena sistem sekarang **1 toko (bukan multi-cabang)**, struktur database jadi sederhana — **tidak perlu tabel `branches` atau kolom `branch_id`** di mana pun.

```bash
php artisan make:model Product -m
php artisan make:model Member -m
php artisan make:model Order -m
```

- [ ] `products` — kolom dasar produk (nama, SKU, kategori, gambar, **harga langsung di tabel ini**) — SKU mengikuti kode dari sistem Affari
- [ ] `members` — kolom: `user_id`, `member_code` (unik, untuk kartu digital/fisik), `tipe` (reguler/pedagang), `points`
- [ ] `cart_items` dan `orders` — struktur standar, **tanpa** kolom `branch_id`

> ✅ **Lebih sederhana dari rencana sebelumnya:** harga produk cukup 1 kolom `price` langsung di tabel `products` — tidak perlu tabel `product_prices` terpisah, karena tidak ada lagi perbedaan harga per cabang.

> ⚠️ **Sebelum mulai:** pastikan isu terbuka #7-8 di PRD v3.0 sudah dijawab klien — **harga mana yang jadi acuan** untuk toko online ini, dan **stok diambil dari cabang/gudang mana**. Jangan mulai impor data Affari sebelum ini jelas.

- [ ] Siapkan script impor CSV/Excel sederhana (`php artisan make:command ImportProducts`) untuk memasukkan data dari export sistem Affari — tanyakan dulu ke pihak IT/operasional klien format file export yang tersedia.

---

## 5. Install Flowbite (Komponen UI — untuk Mahasiswa B)

> **Catatan:** Karena menggunakan Tailwind CSS v4, konfigurasi Flowbite berbeda dengan versi sebelumnya. Tidak perlu `tailwind.config.js`.

```bash
npm i flowbite
```

- [ ] Di `resources/css/app.css`, tambahkan plugin Flowbite:
  ```css
  @import "tailwindcss";

  /* Plugin Flowbite untuk komponen UI */
  @plugin "flowbite/plugin";

  /* Source path agar Tailwind memindai file Flowbite */
  @source "../node_modules/flowbite";
  ```
- [ ] Di `resources/js/app.js`, tambahkan:
  ```js
  import 'flowbite';

  // Inisialisasi ulang setelah navigasi Livewire
  document.addEventListener('livewire:navigated', () => {
      initFlowbite();
  });
  ```

- [ ] **Test:** Pasang 1 komponen dari flowbite.com/docs/components (misal navbar) ke Blade view, pastikan interaktif (dropdown, dll) berfungsi

---

## 6. Struktur Modul & Pembagian Tugas (Kembali ke Per-Layer Teknis)

### Fase 0 — Dibangun Dosen (Fondasi)

- [ ] Setup project Laravel + Livewire + Filament + Tailwind ✅
- [ ] Struktur database inti: `products` (dengan harga langsung), `categories`, `members`
- [ ] Import awal data produk dari Affari (format CSV/Excel)
- [ ] Filament resource untuk kelola produk & kategori
- [ ] View katalog & keranjang (`home.blade.php`, `keranjang.blade.php`, `app.blade.php`)
- [ ] Autentikasi dasar (register/login pembeli)

### Fase 1+ — Dikerjakan Mahasiswa (per Layer)

| Peran | Fokus Modul Laravel | Tools Utama |
|---|---|---|
| **Mahasiswa A** — Backend & Database | Migration, Model, Eloquent relasi: member, poin loyalty, promo engine, riwayat transaksi, Filament Resource | Filament, MySQL |
| **Mahasiswa B** — Frontend/UI | Halaman profil member & kartu digital, riwayat pesanan, tampilan promo, penyesuaian responsif mobile-first | Livewire, Tailwind, Flowbite |
| **Mahasiswa C** — Integrasi & Transaksi | Checkout, verifikasi pembayaran nontunai manual (upload bukti), modul delivery & status pesanan | Livewire |

> **Catatan penting (v3.0):**
> - ✅ **TIDAK menggunakan Midtrans** — pembayaran nontunai dilakukan dengan **verifikasi manual** (upload bukti transfer → admin cek)
> - ✅ **TIDAK menggunakan RajaOngkir di fase awal** — ongkir sederhana: gratis ongkir dgn minimum belanja (kurir internal) / sesuai tarif pihak ketiga
> - ✅ **1 toko, 1 admin** — tidak ada lagi pemisahan cabang, `branch_id`, atau landing page ganda (dibatalkan dari rencana sebelumnya)
> - ✅ Pembagian tugas: **per layer teknis** (Backend/Frontend/Integrasi), bukan per cabang

---

## 7. Urutan Fitur — Fase MVP (10 Minggu, berdasarkan PRD v3.0)

| Fase | Minggu | Fitur | Pengerjaan |
|---|---|---|---|
| **Fase 0** | 1-2 | Fondasi: produk, katalog, cart, auth | **Dosen** |
| **Fase 1** | 3-4 | Checkout dasar (tunai/nontunai manual upload bukti), riwayat transaksi | Mahasiswa C (dipandu) |
| **Fase 2** | 5-6 | Member (kartu digital + kode unik) & poin loyalty (1 poin per Rp100.000 = Rp200) | Mahasiswa A |
| **Fase 3** | 7-8 | Promo engine — mulai 1 skema dulu (**"5 Sip"**), tambah skema lain jika stabil | Mahasiswa A |
| **Fase 4** | 9-10 | Delivery: status manual (diproses/dikirim/selesai), area layanan, gratis ongkir | Mahasiswa C |

> **Prinsip:** Setiap fase harus stabil & teruji sebelum lanjut ke fase berikutnya — jangan mengerjakan semua secara paralel!

### Detail Requirement per Fase

**Fase 0 (Dosen):**
- FR-01: Katalog produk dengan 1 harga per produk
- FR-02: Import data produk dari CSV/Excel (Affari)
- FR-03: Registrasi & login pembeli
- FR-04: CRUD produk via Filament

**Fase 1 (Mahasiswa):**
- FR-05: Tambah ke keranjang & checkout
- FR-06: Metode pembayaran (tunai di lokasi / nontunai upload bukti transfer)
- FR-07: Admin verifikasi pembayaran nontunai
- FR-08: Riwayat transaksi pembeli

**Fase 2 (Mahasiswa):**
- FR-09: Kartu member digital dengan kode unik
- FR-10: Poin otomatis (1 poin per Rp100.000)
- FR-11: Lihat saldo poin di profil

**Fase 3 (Mahasiswa):**
- FR-12: Admin atur promo cut price per produk dengan periode aktif
- FR-13: Harga promo tampil otomatis sesuai jadwal

**Fase 4 (Mahasiswa):**
- FR-14: Pilih kurir internal / pihak ketiga sesuai area layanan
- FR-15: Batasi area sesuai wilayah layanan yang ditentukan klien
- FR-16: Update status (diproses → dikirim → selesai)
- FR-17: Gratis ongkir otomatis jika minimum belanja terpenuhi

---

## 8. Checkpoint Mingguan (Diisi Dosen)

| Minggu | Fase | Target | Status | Catatan |
|---|---|---|---|---|
| 1 | Fase 0 | Setup project awal selesai (dosen) | | |
| 2 | Fase 0 | Katalog & auth berjalan (dosen) | | |
| 3 | Fase 1 | Checkout dasar selesai | | |
| 4 | Fase 1 | Riwayat transaksi selesai | | |
| 5 | Fase 2 | Member & poin loyalty selesai | | |
| 6 | Fase 2 | Profil member & kartu digital selesai | | |
| 7 | Fase 3 | Promo engine (skema "5 Sip") selesai | | |
| 8 | Fase 3 | Stabil & siap lanjut | | |
| 9 | Fase 4 | Delivery status & area selesai | | |
| 10 | Fase 4 | Testing & finalisasi | | |

Setiap checkpoint, dosen memverifikasi:
(a) Fitur berjalan sesuai FR terkait
(b) Mahasiswa dapat menjelaskan alur kodenya sendiri
(c) Tidak ada isu klarifikasi yang masih menggantung

---

## 9. Isu Terbuka — Wajib Diklarifikasi ke Klien Sebelum Fase Terkait Dimulai

| # | Pertanyaan | Relevan Fase |
|---|---|---|
| 1 | **Real-time tracking:** apakah kurir internal pakai HP untuk share lokasi? Atau cukup status manual? | Fase 4 |
| 2 | **Nontunai:** apakah verifikasi transfer manual + admin cek, atau QRIS statis? | Fase 1 |
| 3 | **Member Pedagang:** harga grosir berbeda? Syarat approval khusus? | Fase 2 |
| 4 | **Data Affari:** ada API/export rutin, atau impor manual berkala? | Fase 0 |
| 5 | **Modul kasir toko fisik:** perlu terhubung ke sistem yg sama? | Fase 0-1 |
| 6 | **Estimasi kapasitas:** rata-rata transaksi harian toko saat ini? | Non-fungsional |
| 7 | **Baru (v3.0):** Harga mana yang jadi acuan untuk toko online (karena bisnis fisik punya beberapa cabang dengan harga berbeda, tapi sistem ini cuma 1 toko)? | Fase 0 |
| 8 | **Baru (v3.0):** Stok/fulfillment pesanan online diambil dari cabang atau gudang yang mana? | Fase 0-1 |
| 9 | **Baru (v3.0):** Area layanan delivery untuk toko online tunggal ini mencakup wilayah mana saja? | Fase 4 |

> **Jangan mulai fase terkait sebelum poin klarifikasi di atas dijawab klien** — mencegah rework besar. Poin #7-9 sangat penting dijawab **sebelum Fase 0 impor data**, karena menentukan data harga & stok mana yang dipakai.

---

## 10. Panduan UI/UX (dari PRD & Design System)

Prinsip desain untuk semua halaman:
- Ikon selalu disertai label teks (bukan ikon saja) — target pengguna umum semua usia
- Search bar menonjol di posisi utama
- Kontrol keranjang (+/-) berukuran besar untuk kemudahan sentuh HP
- Rincian harga transparan (subtotal, ongkir, diskon, total)
- CTA utama: satu per halaman, full-width, warna kontras jelas
- **Mobile-first** — mayoritas pembeli akses lewat HP
- Card dengan shadow lembut, hero banner, banner promo 3-kolom, strip trust-badge, FAQ accordion (lihat `UIUX_Design_System_Yugotama_Mart.md` v2.0 untuk detail lengkap)

Halaman yang perlu dibuat oleh mahasiswa B (1x saja, tidak perlu direplikasi):
- Profil member (kartu digital + poin)
- Riwayat transaksi
- Tracking pesanan
- Halaman promo aktif

---

## Referensi Belajar

- Repo referensi e-commerce Laravel + Filament + Livewire + Tailwind:
  https://github.com/vickypandey14/E-commerce-using-Laravel-11-Livewire-3-Filament-3-and-Tailwind-CSS
- Flowbite Quickstart (Tailwind v4): https://flowbite.com/docs/getting-started/quickstart/
- Instalasi Tailwind v4 + Laravel: https://tailwindcss.com/docs/installation/laravel
- Filament docs: https://filamentphp.com/docs
- Livewire docs: https://livewire.laravel.com/docs
- Dokumentasi MAMP: https://documentation-6.mamp.info/en/MAMP-PRO-Mac/
