# PRD — Sistem E-Commerce Yugotama Mart (Yugomart)
### CV Yugotama Megah Abadi Retail
**Versi:** 3.0 | **Tanggal:** 13 Juli 2026 | **Disusun oleh:** [Nama Dosen], dipandu untuk tim magang (3 mahasiswa)

> **Perubahan dari v2.0:** Arsitektur **dikembalikan ke konsep 1 toko** — bukan lagi 3 landing page terpisah per cabang, melainkan **1 sistem, 1 toko online (Yugomart), 1 admin**. Kompleksitas multi-cabang (landing terpisah, `branch_id`, harga per cabang, pembagian tugas per cabang) dihapus dari scope. Pembagian tugas mahasiswa kembali ke pola **per-layer teknis** (Backend, Frontend, Integrasi) seperti rencana awal. Riwayat lengkap perubahan ada di Log Perubahan (Bagian 11).

---

## 1. Ringkasan Eksekutif

Sistem e-commerce **Yugomart** — 1 toko online terpusat untuk CV Yugotama Megah Abadi Retail — mencakup katalog produk, member & loyalty, transaksi (tunai/nontunai), dan delivery. Sistem ini **dikelola oleh 1 admin/owner**, tanpa pemisahan tampilan atau data per cabang fisik.

Pendekatan pengembangan: **bertahap (fase MVP)**, dimulai dari fondasi yang dibangun langsung oleh dosen, kemudian dilanjutkan oleh 3 mahasiswa magang sesuai peran teknis masing-masing, dengan pemantauan mingguan.

**Stack teknis:** Laravel + Livewire + Filament (admin panel) + Tailwind CSS + MySQL

---

## 2. Latar Belakang & Tujuan

Yugotama Mart saat ini mengelola ±51.910 SKU dengan sistem kasir yang terhubung ke sistem pembelian stok **Affari**, dan program member kartu fisik/digital berbayar. Klien meminta sistem e-commerce dengan 4 pilar fitur utama: member, loyalty, transaksi, dan delivery.

**Keputusan scope (v3.0):** meskipun bisnis fisik CV Yugotama Megah Abadi Retail memiliki beberapa cabang dengan kemungkinan harga berbeda, **sistem e-commerce yang dibangun di fase ini merepresentasikan 1 toko online tunggal (Yugomart)** dengan 1 daftar harga dan 1 titik pengelolaan admin — bukan gambaran tiap cabang fisik secara terpisah. Ini keputusan penyederhanaan scope untuk mempercepat MVP dan menyesuaikan kapasitas tim magang.

**Tujuan sistem:**
1. Memungkinkan pembeli belanja online lewat 1 katalog & harga yang konsisten
2. Mendukung program member & poin loyalty yang sudah berjalan
3. Memproses transaksi tunai/nontunai dengan verifikasi manual (tanpa payment gateway)
4. Mendukung pengiriman via kurir internal maupun pihak ketiga dengan tracking status

**Tujuan pengembangan (akademik):**
1. Mahasiswa magang membangun kompetensi coding bertahap lewat proyek nyata
2. Dosen dapat memandu dan memantau progres tanpa harus mengerjakan seluruh sistem sendiri
3. Klien mendapat sistem yang benar-benar dipakai, bukan sekadar demo

---

## 3. Aktor & Role Sistem

| Role | Hak Akses |
|---|---|
| **Owner** | Akses penuh — semua data, laporan, konfigurasi promo, harga, kelola user lain |
| **Admin** | Kelola produk & stok, proses pesanan, verifikasi pembayaran nontunai, update status delivery — **1 admin untuk seluruh toko**, tidak ada pemisahan per cabang |
| **Kasir** | Input transaksi tunai/nontunai di toko (jika modul kasir disatukan — *perlu klarifikasi ke klien, lihat Bagian 9*) |
| **Kurir** | Update status pengiriman (untuk kurir internal) |
| **Pembeli (User)** | Registrasi/login, belanja, checkout, lihat riwayat & poin, tracking pesanan |

---

## 4. Data Bisnis Kunci (Hasil Wawancara Klien)

| Aspek | Ketentuan |
|---|---|
| Jumlah SKU | 51.910 (aktif & nonaktif), sumber data dari sistem Affari |
| Stok | Berkurang otomatis saat transaksi kasir; penambahan stok diinput lewat Affari |
| Harga | **1 daftar harga untuk seluruh toko online** (disederhanakan di v3.0 — lihat catatan scope di Bagian 2; *harga berbeda per cabang fisik ada di data asli klien, tapi di luar scope sistem versi ini, perlu diklarifikasi ke klien mana yang jadi acuan harga online, lihat Bagian 9*) |
| Promo | 4 skema rutin, semua model *cut price*: **5 Sip**, **Semur** (Senin-Selasa), **Beweekly**, **Gantung** (gajian) |
| Member | Kartu fisik (berbayar) & digital, berisi kode member unik |
| Poin | Belanja ≥ Rp100.000 → 1 poin (setara Rp200) |
| Tingkatan member | **Reguler** & **Pedagang** (bukan tier silver/gold biasa — kemungkinan harga/diskon grosir berbeda, *perlu klarifikasi*) |
| Pembayaran | Tunai & nontunai, **tanpa payment gateway** (*perlu klarifikasi mekanisme verifikasi nontunai online*) |
| Pajak | Harga di toko sudah termasuk pajak (harga final, tidak perlu hitung PPN terpisah) |
| Delivery | Kurir internal + pihak ketiga; area layanan mengikuti jangkauan toko Yugomart (*area spesifik perlu dikonfirmasi ke klien — lihat Bagian 9*) |
| Tracking | Diminta **real-time tracking** (lihat catatan kompleksitas di Bagian 9) |
| Ongkir | Gratis ongkir dengan minimum belanja (kurir internal); pihak ketiga mengikuti skema aplikasi masing-masing |
| Kapasitas transaksi | Tidak dibatasi klien — akan diestimasi berdasarkan rata-rata transaksi harian toko fisik saat ini |
| Integrasi sistem lama | Tidak ada permintaan integrasi ke sistem akuntansi, hanya perlu strategi impor data dari Affari |
| KPI utama | Jumlah transaksi online |

---

## 5. Arsitektur Sistem: 1 Toko, 1 Admin

### 5.1 Konsep

Sistem Yugomart adalah **1 aplikasi web tunggal** — 1 landing page, 1 katalog, 1 keranjang/checkout per pembeli, 1 panel admin. Tidak ada pemisahan tampilan atau data berdasarkan cabang fisik.

### 5.2 Struktur URL (Sederhana)

```
yugomart.com/                  -> homepage & katalog
yugomart.com/produk/{slug}     -> detail produk
yugomart.com/keranjang         -> keranjang belanja
yugomart.com/checkout          -> checkout
yugomart.com/profil            -> profil member
yugomart.com/admin/            -> panel admin (Filament)
```

### 5.3 Implikasi Teknis

- **Tidak perlu `branch_id`** di tabel `products`, `cart_items`, maupun `orders` — struktur data jadi jauh lebih sederhana dibanding rencana multi-cabang sebelumnya
- **1 tabel harga per produk** (`products.price` langsung, atau tabel `product_prices` sederhana tanpa relasi ke cabang) — cukup 1 harga per SKU
- **1 komponen Blade per halaman** — tidak ada lagi pembedaan "shared component vs view per cabang", karena hanya ada 1 versi dari tiap halaman
- **Admin tetap 1 panel Filament**, dipakai owner & admin, tanpa perlu filter data per cabang

### 5.4 Pembagian Kerja: Dosen vs Mahasiswa (Kembali ke Per-Layer)

### Fase 0 — Dibangun Dosen (Fondasi)

- [ ] Setup project Laravel + Livewire + Filament + Tailwind (sudah ada checklist terpisah)
- [ ] Struktur database inti: `products`, `categories`, harga langsung per produk
- [ ] Import awal data produk dari Affari (CSV/Excel)
- [ ] Filament admin dasar: kelola produk & kategori
- [ ] View katalog & keranjang dasar
- [ ] Autentikasi dasar (register/login pembeli)

### Fase 1+ — Dipandu ke Mahasiswa (per Layer Teknis)

| Peran | Tanggung Jawab |
|---|---|
| **Mahasiswa A** — Backend & Database | Lanjutkan pola Fase 0 untuk: member, poin, promo engine, riwayat transaksi |
| **Mahasiswa B** — Frontend/UI | Halaman profil member, riwayat pesanan, tampilan promo, penyesuaian responsif |
| **Mahasiswa C** — Integrasi & Transaksi | Checkout, verifikasi pembayaran nontunai manual, modul delivery & status pesanan |

> Pembagian ini kembali ke rencana paling awal proyek — lebih sesuai untuk 1 sistem tunggal, dan tetap mempertahankan prinsip "1 pola dari dosen, mahasiswa melanjutkan sesuai layer keahlian masing-masing".

---

## 6. Roadmap Fase MVP

| Fase | Fitur | Dikerjakan | Estimasi |
|---|---|---|---|
| **0** | Fondasi: struktur produk, katalog, cart, auth | Dosen | Minggu 1-2 |
| **1** | Checkout dasar (tunai/nontunai manual), riwayat transaksi | Mahasiswa C (dipandu) | Minggu 3-4 |
| **2** | Member (kartu digital + kode unik) & poin loyalty dasar | Mahasiswa A | Minggu 5-6 |
| **3** | Promo engine — **mulai 1 skema dulu** (misal "5 Sip"), baru tambah skema lain jika stabil | Mahasiswa A | Minggu 7-8 |
| **4** | Delivery: status manual (diproses/dikirim/selesai) + area layanan | Mahasiswa C | Minggu 9-10 |
| **5** *(lanjutan, pasca-magang atau jika waktu cukup)* | Member Pedagang, real-time tracking penuh, sinkronisasi otomatis dengan Affari, 3 skema promo lainnya, evaluasi apakah perlu ekspansi ke multi-cabang di masa depan | Dosen + tim lanjutan | Setelah evaluasi Fase 0-4 |

**Prinsip fase:** setiap fase harus *stabil dan teruji* sebelum lanjut ke fase berikutnya — bukan mengerjakan semua secara paralel dari awal.

---

## 7. Requirement Fungsional per Fase

### Fase 0 (Dosen)
- FR-01: Sistem dapat menampilkan katalog produk dengan 1 harga per produk
- FR-02: Sistem dapat mengimpor data produk dari file CSV/Excel (hasil ekspor dari Affari)
- FR-03: Pengguna dapat registrasi dan login sebagai pembeli
- FR-04: Admin dapat menambah/edit/hapus produk lewat panel Filament

### Fase 1
- FR-05: Pengguna dapat menambah produk ke keranjang dan checkout
- FR-06: Sistem mencatat metode pembayaran (tunai di lokasi / nontunai — transfer manual dengan bukti upload)
- FR-07: Admin dapat memverifikasi pembayaran nontunai sebelum pesanan diproses
- FR-08: Pengguna dapat melihat riwayat transaksi

### Fase 2
- FR-09: Pengguna dapat memiliki kartu member digital dengan kode unik
- FR-10: Sistem otomatis menghitung poin (1 poin per kelipatan Rp100.000 belanja)
- FR-11: Pengguna dapat melihat saldo poin di profil

### Fase 3
- FR-12: Admin dapat mengatur promo cut price per produk dengan periode aktif (harian/mingguan)
- FR-13: Sistem menampilkan harga promo otomatis sesuai jadwal aktif tanpa intervensi manual harian

### Fase 4
- FR-14: Pengguna dapat memilih metode pengiriman (kurir internal / pihak ketiga) sesuai area layanan yang didukung
- FR-15: Sistem membatasi pemilihan delivery hanya untuk area layanan yang ditentukan klien
- FR-16: Admin/kurir dapat mengubah status pesanan (diproses → dikirim → selesai)
- FR-17: Sistem menerapkan gratis ongkir otomatis jika belanja mencapai minimum tertentu (kurir internal)

---

## 8. Requirement Non-Fungsional

- NFR-01: Sistem harus responsif (mobile-first), karena mayoritas pembeli diasumsikan mengakses lewat HP
- NFR-02: Waktu muat halaman katalog < 3 detik pada koneksi standar
- NFR-03: Setiap perubahan status pesanan harus tercatat dengan timestamp (audit trail sederhana)
- NFR-04: Kapasitas server disesuaikan bertahap — mulai dari estimasi berbasis rata-rata transaksi kasir harian saat ini (perlu data dari klien), bukan asumsi "tidak terbatas" di awal

---

## 9. Isu Terbuka — Wajib Diklarifikasi ke Klien Sebelum Fase Terkait Dimulai

| # | Pertanyaan | Relevan untuk Fase |
|---|---|---|
| 1 | Real-time tracking: apakah kurir internal akan menggunakan aplikasi/HP untuk share lokasi? Atau cukup status manual di fase awal, real-time menyusul di Fase 5? | Fase 4 |
| 2 | Nontunai tanpa payment gateway: apakah verifikasinya transfer manual + cek admin, atau QRIS statis? | Fase 1 |
| 3 | Member Pedagang: apakah dapat harga grosir berbeda, syarat approval khusus? | Fase 2 |
| 4 | Data dari Affari: apakah tersedia API/export rutin, atau impor manual berkala? | Fase 0 |
| 5 | Apakah modul kasir toko fisik perlu terhubung ke sistem yang sama, atau sistem online berdiri sendiri? | Fase 0-1 |
| 6 | Berapa rata-rata transaksi harian toko fisik saat ini? (untuk estimasi kapasitas server yang realistis) | Non-fungsional |
| 7 | **Baru (v3.0):** Karena sistem sekarang 1 toko online (bukan per cabang), **harga mana yang jadi acuan** untuk katalog online — harga cabang tertentu, atau daftar harga baru yang disepakati klien? | Fase 0 |
| 8 | **Baru (v3.0):** Untuk stok & fulfillment — pesanan online diambil dari stok cabang mana? Apakah perlu 1 gudang/cabang khusus untuk fulfillment online? | Fase 0-1 |
| 9 | **Baru (v3.0):** Area layanan delivery untuk toko online tunggal ini mencakup wilayah mana saja? | Fase 4 |

> **Catatan:** Jangan mulai fase terkait sebelum poin klarifikasi di atas dijawab klien — ini mencegah rework besar di tengah pengembangan. Poin #7-9 muncul karena penyederhanaan dari multi-cabang ke 1 toko — sangat penting diklarifikasi di awal Fase 0 supaya tidak salah asumsi harga/stok.

---

## 10. Panduan UI/UX

Mockup homepage/katalog & cart/checkout sudah dibuat dengan prinsip (lihat `UIUX_Design_System_Yugotama_Mart.md` untuk detail lengkap, termasuk arah visual modern v2.0):
- Ikon selalu disertai label teks (bukan ikon saja) — target pengguna masyarakat umum semua usia
- Search bar menonjol di posisi utama
- Kontrol keranjang (+/-) berukuran besar untuk kemudahan sentuh di HP
- Rincian harga transparan (subtotal, ongkir, diskon, total) untuk membangun kepercayaan
- CTA utama selalu satu per halaman, full-width, warna kontras jelas
- Card dengan shadow lembut, hero banner, banner promo 3-kolom, strip trust-badge, FAQ accordion (arah visual v2.0)

> **Catatan (v3.0):** karena sistem sekarang 1 toko (bukan multi-cabang), **semua halaman cukup didesain & dibangun 1x** — tidak perlu lagi direplikasi 3x per cabang seperti rencana v2.0. Dokumen `Prompt_UIUX_Per_Halaman_Yugotama_Mart.md` perlu disesuaikan ulang untuk menghapus catatan "per-cabang" di tiap prompt.

Halaman berikutnya yang perlu dirancang dengan prinsip sama: profil member (kartu digital + poin), riwayat transaksi, tracking pesanan, halaman promo aktif.

---

## 11. Mekanisme Perubahan / Update Khusus

Karena proyek ini melibatkan klien, dosen, dan 3 mahasiswa, perubahan permintaan (baik dari klien maupun temuan teknis di tengah jalan) **wajib dicatat terstruktur**, bukan langsung dieksekusi tanpa jejak:

1. **Setiap permintaan perubahan** (fitur baru, ubah alur, dsb.) dicatat di tabel **Log Perubahan** di bagian bawah dokumen ini, dengan format: tanggal, diminta oleh siapa, deskripsi, fase terdampak, status (diusulkan/disetujui/ditolak/selesai).
2. Perubahan **hanya dieksekusi setelah disetujui dosen** (dan klien, jika menyangkut scope fitur), untuk menghindari mahasiswa mengerjakan permintaan dadakan yang mengganggu fase berjalan.
3. Jika perubahan berdampak ke fase yang sudah selesai, dicatat sebagai **versi baru** dokumen ini (naikkan nomor versi di judul), bukan menimpa versi sebelumnya.
4. Perubahan kecil (styling, teks, perbaikan bug) tidak perlu proses persetujuan formal — cukup dicatat di commit message Git oleh mahasiswa terkait.

### Log Perubahan

| Tanggal | Diminta oleh | Deskripsi Perubahan | Fase Terdampak | Status |
|---|---|---|---|---|
| 12 Juli 2026 | Dosen | Arsitektur diubah dari "1 landing dengan pilihan cabang" menjadi **3 landing page terpisah per cabang**, backend & admin tetap 1 sistem terpusat. Pembagian tugas mahasiswa berubah dari per-layer teknis menjadi per-cabang + 1 modul shared masing-masing. | Fase 0-4 (seluruh roadmap) | Disetujui, masuk v2.0 |
| 13 Juli 2026 | Dosen | Arsitektur **dikembalikan ke 1 toko (Yugomart), 1 admin** — multi-cabang dibatalkan. Struktur database disederhanakan (hapus `branch_id`, harga per cabang). Pembagian tugas mahasiswa dikembalikan ke per-layer teknis (Backend/Frontend/Integrasi). | Fase 0-4 (seluruh roadmap) | Disetujui, masuk v3.0 |

---

## 12. Checkpoint & Pemantauan Dosen

| Minggu | Fase | Target | Status |
|---|---|---|---|
| 1-2 | Fase 0 | Fondasi selesai, katalog & auth jalan | |
| 3-4 | Fase 1 | Checkout & riwayat transaksi | |
| 5-6 | Fase 2 | Member & poin | |
| 7-8 | Fase 3 | Promo engine (1 skema) | |
| 9-10 | Fase 4 | Delivery status & area | |

Setiap checkpoint, dosen memverifikasi: (a) fitur berjalan sesuai FR terkait, (b) mahasiswa dapat menjelaskan alur kodenya sendiri, (c) tidak ada isu klarifikasi di Bagian 9 yang masih menggantung untuk fase tersebut.

---

## 13. Metrik Keberhasilan (KPI)

- **KPI utama (sesuai permintaan klien):** jumlah transaksi online per periode
- KPI pendukung yang disarankan untuk dipantau (opsional, bisa didiskusikan dengan klien): tingkat konversi katalog→checkout, jumlah member baru terdaftar, rata-rata nilai transaksi

---

## 14. Lampiran

- Referensi stack: Laravel + Livewire + Filament + Tailwind CSS
- Starter code homepage & keranjang: `home.blade.php`, `keranjang.blade.php`, `layouts/app.blade.php` (sudah dibuat terpisah — *perlu disederhanakan, hapus referensi branch/cabang*)
- Checklist instalasi environment: `Checklist_Starter_Project_Ecommerce_Laravel.md` (sudah dibuat terpisah — *perlu direvisi ulang ke konsep 1 toko*)
- Design System UI/UX: `UIUX_Design_System_Yugotama_Mart.md` v2.0
- Kumpulan prompt UI/UX per halaman: `Prompt_UIUX_Per_Halaman_Yugotama_Mart.md` (*perlu direvisi ulang, hapus klasifikasi "per-cabang"*)
- Panduan TDD: `TDD_Guide_Ecommerce_Yugotama_Mart.md`

> **Dokumen turunan yang masih perlu disinkronkan ke v3.0:** Checklist Starter Project dan Prompt UI/UX per Halaman masih mengacu ke arsitektur multi-cabang (v2.0) — perlu direvisi supaya konsisten dengan keputusan 1 toko ini.
