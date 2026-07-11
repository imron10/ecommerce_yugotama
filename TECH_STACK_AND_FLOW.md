# Tech Stack & Flow Aplikasi — Yugotama Mart

> **Proyek:** E-Commerce Supermarket Multi-Cabang
> **Stack:** Laravel + Livewire + Filament + Tailwind CSS v4 + MySQL
> **Tim:** 1 Dosen (Fase 0) + 3 Mahasiswa (Fase 1+)

---

## 1. Tech Stack Lengkap

### Backend / Server

| Teknologi | Versi | Fungsi |
|---|---|---|
| **PHP** | ^8.3 | Bahasa pemrograman utama |
| **Laravel** | ^13.8 | Framework MVC — routing, ORM (Eloquent), autentikasi, Blade templating, migrasi database |
| **Livewire** | ^4.3 | Komponen interaktif tanpa JavaScript manual — katalog filter, cari, ganti cabang tanpa reload |
| **Filament** | ^5.6 | Admin Panel — CRUD produk, kategori, cabang, harga per cabang (akses di `/admin`) |
| **MySQL** (via MAMP) | — | Database relasional (port 8889, user `root`, password `root`) |
| **Laravel Breeze** | ^2.4 | Scaffolding autentikasi (register, login, lupa password, verifikasi email) |

### Frontend / UI

| Teknologi | Fungsi |
|---|---|
| **Tailwind CSS v4** | Utility-first CSS framework — styling pakai class seperti `bg-primary-700`, `text-white` |
| **Vite** | Build tool & hot-reload saat development |
| **Alpine.js** | Interaktivitas ringan di Blade (toggle kartu member, dropdown navbar) |
| **Flowbite** | Komponen UI siap pakai (navbar, dropdown, modal) |
| **Plus Jakarta Sans** | Font heading — modern, readable (Google Fonts) |
| **Inter** | Font body — readable untuk teks panjang (Google Fonts) |

### Database (5 Model)

```
Branch ──────────┐          ┌── User (pembeli / admin)
(cabang)         │          │
                 ▼          ▼
Category ─── Product ── ProductPrice
(kategori)    (produk)    (harga per cabang)
```

| Model | Tabel | Isi |
|---|---|---|
| `Branch` | `branches` | Cabang toko: Samarinda (SMR), Seberang (SDL), Palaran (PLR) |
| `Category` | `categories` | Kategori produk: Beras & Tepung, Minyak & Sembako, dll |
| `Product` | `products` | Produk: nama, SKU, gambar, status aktif |
| `ProductPrice` | `product_prices` | Harga per produk per cabang (key: `product_id` + `branch_id`) |
| `User` | `users` | Pembeli & admin — role: `admin` atau `pembeli` |

**Data saat ini:** 12 produk aktif, 5 kategori, 3 cabang, 28 harga per cabang.

### Struktur File

```
ecommerce_yugotama/
├── routes/
│   ├── web.php        ── Routing halaman publik (/, /produk, /dashboard, /profile)
│   └── auth.php       ── Routing autentikasi (login, register, logout, reset password)
├── app/
│   ├── Livewire/
│   │   ├── Counter.php
│   │   └── KatalogProduk.php    ── Komponen katalog Livewire (filter, cari, cabang)
│   ├── Models/
│   │   ├── Branch.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── ProductPrice.php
│   │   └── User.php
│   └── Http/Controllers/
│       └── Auth/                 ── Controller autentikasi Breeze
└── resources/
    ├── css/app.css               ── Tailwind v4 + custom theme
    ├── js/app.js                 ── Alpine.js + Flowbite + Livewire handler
    └── views/
        ├── welcome.blade.php     ── HOMEPAGE (hero, kategori, promo, produk)
        ├── dashboard.blade.php   ── Dashboard admin
        ├── layouts/
        │   ├── app.blade.php     ── Layout setelah login
        │   ├── guest.blade.php   ── Layout halaman guest
        │   └── navigation.blade.php ── Navigasi utama
        ├── livewire/
        │   └── katalog-produk.blade.php ── View katalog Livewire
        └── components/
            ├── product-card.blade.php   ── Kartu produk reusable
            └── promo-badge.blade.php    ── Badge promo reusable
```

---

## 2. Flow Aplikasi — Peta Navigasi

```
                    ┌──────────────────────────────────────────┐
                    │              HOMEPAGE                     │
                    │          GET  /                           │
                    │  ┌───────────────────────────────────┐    │
                    │  │ HEADER: Logo | 🔍 SEARCH | 👤     │    │
                    │  │         Akun | 🛒 Keranjang       │    │
                    │  └───────────────────────────────────┘    │
                    │            │                              │
                    │  ┌───────────────────────────────────┐    │
                    │  │ Pilih Cabang ▼ (SMR/SDL/PLR)      │    │
                    │  │ └→ harga berubah otomatis          │    │
                    │  └───────────────────────────────────┘    │
                    │            │                              │
                    │  KATEGORI (horizontal scroll)             │
                    │  🍚 Beras │ 🛢️ Minyak │ 🥛 Susu │ ...    │
                    │            │                              │
                    │  BANNER PROMO: [5 Sip] [Semur]            │
                    │  [Beweekly] [Gantung]                     │
                    │            │                              │
                    │  PRODUK PILIHAN:                          │
                    │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐    │
                    │  │📦    │ │📦    │ │📦    │ │📦    │    │
                    │  │Nama  │ │Nama  │ │Nama  │ │Nama  │    │
                    │  │Rp    │ │Rp    │ │Rp    │ │Rp    │    │
                    │  │+Cart │ │+Cart │ │+Cart │ │+Cart │    │
                    │  └──────┘ └──────┘ └──────┘ └──────┘    │
                    │            │                              │
                    │  FOOTER: Info toko, kontak                │
                    └────────────┬─────────────────────────────┘
                                 │
            ┌────────────────────┼────────────────────────┐
            ▼                    ▼                        ▼
    ┌───────────────┐    ┌───────────────┐       ┌──────────────┐
    │   KATALOG     │    │   LOGIN       │       │  REGISTER    │
    │  GET /produk  │    │  GET /login   │       │ GET /register│
    │  (Livewire!)  │    │               │       │              │
    │               │    └───────┬───────┘       └──────┬───────┘
    │ Fitur:        │            │                       │
    │ ✅ Pilih      │            └──────────┬─────────────┘
    │    cabang     │                       ▼
    │ ✅ Filter     │               ┌─────────────────┐
    │    kategori   │               │  SESSION LOGIN  │
    │ ✅ Cari       │               └────────┬────────┘
    │    produk     │                        │
    │ ✅ Grid       │           ┌────────────┼────────────┐
    │    produk     │           ▼            ▼            ▼
    │ ✅ Harga      │    ┌──────────┐ ┌──────────┐ ┌────────────┐
    │    per cabang │    │DASHBOARD │ │ KATALOG  │ │  PROFILE   │
    └───────┬───────┘    │(admin)   │ │(sama)    │ │ GET /profi │
            │            │/dashboard │ │+ member  │ │  le        │
            │            └──────────┘ │  card    │ │            │
            │                        └──────────┘ │ Edit nama  │
            ▼                                     │ email,     │
    ┌───────────────┐                             │ password   │
    │  FILAMENT     │                             └────────────┘
    │  ADMIN PANEL  │
    │  GET /admin   │
    │               │
    │ ┌───────────┐ │
    │ │ PRODUK    │ │── CRUD: nama, SKU, gambar, kategori
    │ ├───────────┤ │
    │ │ KATEGORI  │ │── CRUD: nama, icon, urutan
    │ ├───────────┤ │
    │ │ CABANG    │ │── CRUD: nama, alamat, status aktif
    │ ├───────────┤ │
    │ │ HARGA PER │ │── Set harga setiap produk per cabang
    │ │  CABANG   │ │
    │ └───────────┘ │
    └───────────────┘
```

---

## 3. Alur Data Kunci

### 3.1 Harga Per Cabang

```
User pilih "Samarinda" di dropdown
         │
         ▼
URL berubah: /?cabang=1  atau  /produk?cabang=1
         │
         ▼
Query ProductPrice → where('branch_id', 1)
         │
         ▼
Contoh:
  Beras Ramos    → Rp 15.000 (Samarinda)
  Minyak Goreng  → Rp 22.500 (Samarinda)

Kalau pilih "Palaran" (?cabang=3):
  Beras Ramos    → Rp 15.500 (Palaran)
```

### 3.2 Livewire Katalog (Interaktif Tanpa Reload)

```
1. User buka /produk
   → KatalogProduk Livewire component di-mount
   → mount() ambil semua produk, kategori, cabang dari DB
   → render() kirim data ke view blade

2. User klik kategori "Beras"
   → $filteredCategory = 1 (ID kategori)
   → Komponen re-render otomatis (via AJAX)
   → Hanya produk kategori Beras yang tampil

3. User ketik "minyak" di search
   → $search = "minyak"
   → Query produk where nama like '%minyak%'
   → Grid produk berisi Minyak Goreng, Minyak Kelapa, dll.

4. User ganti cabang
   → Harga semua produk berubah tanpa reload halaman
```

### 3.3 Autentikasi (Laravel Breeze)

```
Guest:
  /register → isi nama, email, password → terdaftar
  /login → email + password → session login

Pembeli (sudah login):
  / → lihat homepage + kartu member digital + badge keranjang
  /produk → sama seperti guest
  /profile → edit nama, email, password, hapus akun

Admin:
  login: admin@yugotama.com / password123
  /dashboard → dashboard admin (statistik ringkasan)
  /admin → Filament panel (CRUD produk, kategori, cabang, harga)
```

---

## 4. Role & Hak Akses

| Role | Yang Bisa Diakses |
|---|---|
| **Guest** (belum login) | `/` (homepage), `/produk` (katalog), `/login`, `/register` |
| **Pembeli** (sudah login) | Semua guest + kartu member digital, badge keranjang, `/profile` |
| **Admin** | Semua di atas + `/dashboard`, `/admin` (CRUD Filament) |

### Akun Siap Pakai

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@yugotama.com | password123 |
| **Pembeli** | (daftar via register) | (buat sendiri) |

---

## 5. Design System

### Palet Warna

| Token | Hex | Penggunaan |
|---|---|---|
| `primary-700` | `#1E5631` | Warna utama brand — header, tombol, harga |
| `primary-500` | `#2F7D46` | Ikon kategori, link, elemen sekunder |
| `primary-100` | `#E7F3EA` | Background section, hover state |
| `accent-500` | `#F2A93B` | Badge promo/diskon, highlight harga coret |
| `accent-100` | `#FDF1DC` | Background banner promo |
| `neutral-900` | `#1A1D1B` | Teks utama |
| `neutral-500` | `#6B7069` | Teks sekunder, placeholder |
| `neutral-100` | `#F5F6F4` | Background halaman, card kosong |
| `danger-500` | `#D64545` | Error, stok habis, hapus item |
| `success-500` | `#2F9E5C` | Konfirmasi berhasil, status selesai |

### Tipografi

| Elemen | Font | Ukuran | Weight |
|---|---|---|---|
| Heading besar | Plus Jakarta Sans | 28-32px | 600 |
| Heading kecil | Plus Jakarta Sans | 18-20px | 600 |
| Body / teks umum | Inter | 15-16px | 400 |
| Harga produk | Inter | 16-18px | 600 |
| Label kecil | Inter | 12-13px | 500 |

### Prinsip Desain

1. **Trust-first, bukan trendy-first** — flat design, hindari gradient & glassmorphism berlebihan
2. **Aksesibel semua usia** — kontras tinggi, teks min 14px, touch target min 44x44px
3. **Mobile-first** — uji di 375px dulu baru desktop
4. **Konsisten** — komponen reusable (`product-card`, `promo-badge`) dipakai di semua halaman

---

## 6. Status Fase MVP

| Fase | Fitur | Deadline | Status |
|---|---|---|---|
| **0** 🟢 | Fondasi: produk, harga per cabang, katalog, auth, Filament admin, UI design system | Minggu 1-2 | ✅ **Selesai** |
| **1** 🔴 | Checkout (keranjang, pesan, upload bukti bayar), riwayat transaksi | Minggu 3-4 | ⏳ Belum |
| **2** 🔴 | Member digital (kode unik) & poin loyalty (1 poin/Rp100rb = Rp200) | Minggu 5-6 | ⏳ Belum |
| **3** 🔴 | Promo engine (5 Sip sebagai pilot, cut price per produk, jadwal otomatis) | Minggu 7-8 | ⏳ Belum |
| **4** 🔴 | Delivery (kurir internal/eksternal, status manual, gratis ongkir, batas area) | Minggu 9-10 | ⏳ Belum |

### Pembagian Tugas Fase 1+

| Peran | Tanggung Jawab |
|---|---|
| **Mahasiswa A** — Backend & DB | Member, poin, promo engine, riwayat transaksi, Filament Resource |
| **Mahasiswa B** — Frontend/UI | Profil member, kartu digital, riwayat pesanan, tampilan promo, responsive |
| **Mahasiswa C** — Integrasi & Transaksi | Checkout, verifikasi bayar (upload bukti), delivery & status pesanan |

---

## 7. Cara Menjalankan

### Mode Development (2 terminal — hot reload)

```bash
# Terminal 1 — Vite hot reload CSS/JS
cd ecommerce_yugotama && npm run dev

# Terminal 2 — Laravel server
cd ecommerce_yugotama && php artisan serve
```

→ Akses **http://127.0.0.1:8000**

### Mode Production (1 terminal — build statis)

```bash
cd ecommerce_yugotama
npm run build           # Build CSS/JS ke public/build/
rm -f public/hot        # Penting! hapus file sisa Vite dev server
php artisan serve
```

→ Akses **http://127.0.0.1:8000**

---

## 8. Troubleshooting Umum

| Masalah | Penyebab | Solusi |
|---|---|---|
| Halaman tanpa CSS (berantakan) | File `public/hot` masih ada | `rm -f public/hot` lalu `npm run build` |
| Error `@import must precede all other statements` | Syntax Tailwind v3 + v4 tercampur | Hapus `@tailwind base/components/utilities`, pakai `@import "tailwindcss"` saja |
| Error `Unknown word "use strict"` | `tailwindcss` masih v3 | `npm install tailwindcss@latest` |
| Build gagal setelah upgrade | Plugin `@tailwindcss/vite` tidak terdaftar | Tambahkan `tailwindcss()` plugin di `vite.config.js` |
| `npm: command not found` | Salah folder | `cd ecommerce_yugotama` dulu |
| Port 8000 sudah dipakai | Ada server lain | Ganti port: `php artisan serve --port=8080` |

---

## 9. Referensi

- [PRD E-Commerce Yugotama Mart](PRD_Ecommerce_Yugotama_Mart.md)
- [UI/UX Design System](UIUX_Design_System_Yugotama_Mart.md)
- [Checklist Starter Project](Checklist_Starter_Project_Ecommerce_Laravel.md)
- [Tailwind CSS v4 Docs](https://tailwindcss.com/docs)
- [Laravel Docs](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com/docs)
- [Filament Docs](https://filamentphp.com/docs)
- [Flowbite Quickstart](https://flowbite.com/docs/getting-started/quickstart/)
