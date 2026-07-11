# PRD — Sistem E-Commerce Yugotama Mart
### CV Yugotama Megah Abadi Retail
**Versi:** 1.0 | **Tanggal:** 8 Juli 2026 | **Disusun oleh:** [Nama Dosen], dipandu untuk tim magang (3 mahasiswa)

---

## 1. Ringkasan Eksekutif

Sistem e-commerce untuk Yugotama Mart (supermarket retail multi-cabang) yang mencakup katalog produk, member & loyalty, transaksi (tunai/nontunai), dan delivery dengan area terbatas (Samarinda, Samarinda Seberang, Palaran).

Pendekatan pengembangan: **bertahap (fase MVP)**, dimulai dari fondasi yang dibangun langsung oleh dosen, kemudian dilanjutkan oleh 3 mahasiswa magang sesuai peran masing-masing, dengan pemantauan mingguan.

**Stack teknis:** Laravel + Livewire + Filament (admin panel) + Tailwind CSS + MySQL

---

## 2. Latar Belakang & Tujuan

Yugotama Mart saat ini mengelola ±51.910 SKU dengan sistem kasir yang terhubung ke sistem pembelian stok **Affari**, harga berbeda per cabang, dan program member kartu fisik/digital berbayar. Klien meminta sistem e-commerce dengan 4 pilar fitur utama: member, loyalty, transaksi, dan delivery.

**Tujuan sistem:**
1. Memungkinkan pembeli belanja online dengan katalog dan harga sesuai cabang terdekat
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
| **Owner** | Akses penuh — semua data, laporan, konfigurasi promo, harga per cabang, kelola user lain |
| **Admin** (per cabang) | Kelola produk & stok cabang, proses pesanan, verifikasi pembayaran nontunai, update status delivery |
| **Kasir** | Input transaksi tunai/nontunai di toko (jika modul kasir disatukan — *perlu klarifikasi ke klien, lihat Bagian 9*) |
| **Kurir** | Update status pengiriman & lokasi (untuk kurir internal) |
| **Pembeli (User)** | Registrasi/login, belanja, checkout, lihat riwayat & poin, tracking pesanan |

---

## 4. Data Bisnis Kunci (Hasil Wawancara Klien)

| Aspek | Ketentuan |
|---|---|
| Jumlah SKU | 51.910 (aktif & nonaktif), sumber data dari sistem Affari |
| Stok | Berkurang otomatis saat transaksi kasir; penambahan stok diinput lewat Affari |
| Harga | **Berbeda per cabang** — wajib skema harga per-produk-per-cabang |
| Promo | 4 skema rutin, semua model *cut price*: **5 Sip**, **Semur** (Senin-Selasa), **Beweekly**, **Gantung** (gajian) |
| Member | Kartu fisik (berbayar) & digital, berisi kode member unik |
| Poin | Belanja ≥ Rp100.000 → 1 poin (setara Rp200) |
| Tingkatan member | **Reguler** & **Pedagang** (bukan tier silver/gold biasa — kemungkinan harga/diskon grosir berbeda, *perlu klarifikasi*) |
| Pembayaran | Tunai & nontunai, **tanpa payment gateway** (*perlu klarifikasi mekanisme verifikasi nontunai online*) |
| Pajak | Harga di toko sudah termasuk pajak (harga final, tidak perlu hitung PPN terpisah) |
| Delivery | Kurir internal + pihak ketiga; area: **Samarinda, Samarinda Seberang, Palaran** |
| Tracking | Diminta **real-time tracking** (lihat catatan kompleksitas di Bagian 9) |
| Ongkir | Gratis ongkir dengan minimum belanja (kurir internal); pihak ketiga mengikuti skema aplikasi masing-masing |
| Kapasitas transaksi | Tidak dibatasi klien — akan diestimasi berdasarkan rata-rata transaksi harian toko fisik saat ini |
| Integrasi sistem lama | Tidak ada permintaan integrasi ke sistem akuntansi, hanya perlu strategi impor data dari Affari |
| KPI utama | Jumlah transaksi online |

---

## 5. Prinsip Pembagian Kerja: Dosen vs Mahasiswa

Karena Bapak ingin **membangun fondasi sistem terlebih dahulu** sebelum diserahkan ke mahasiswa, pembagian dibuat sebagai berikut:

### Fase 0 — Dibangun Dosen (Fondasi & Referensi)
Tujuan: menyediakan kerangka kerja yang sudah berjalan, supaya mahasiswa tinggal mengikuti pola yang sama (bukan mulai dari nol).

- [ ] Setup project Laravel + Livewire + Filament + Tailwind (sudah ada checklist terpisah)
- [ ] Struktur database inti: `products`, `branches` (cabang), `product_prices` (harga per cabang), `categories`
- [ ] Import awal data produk dari Affari (format CSV/Excel) — 1 script import sederhana
- [ ] Filament admin dasar untuk kelola produk & cabang
- [ ] View katalog & keranjang (sudah dibuat sebelumnya: `home.blade.php`, `keranjang.blade.php`)
- [ ] Autentikasi dasar (register/login pembeli)

> Setelah Fase 0 selesai dan berjalan, ini menjadi **contoh pola kerja** yang mahasiswa tiru untuk modul-modul berikutnya (Fase 1 dst).

### Fase 1+ — Dipandu ke Mahasiswa (sesuai peran)

| Peran | Tanggung Jawab |
|---|---|
| **Mahasiswa A** — Backend & Database | Lanjutkan pola Fase 0 untuk: member, poin, promo engine, riwayat transaksi |
| **Mahasiswa B** — Frontend/UI | Halaman profil member, riwayat pesanan, tampilan promo, penyesuaian responsif |
| **Mahasiswa C** — Integrasi & Transaksi | Checkout, verifikasi pembayaran nontunai manual, modul delivery & status pesanan |

---

## 6. Roadmap Fase MVP

| Fase | Fitur | Dikerjakan | Estimasi |
|---|---|---|---|
| **0** | Fondasi: struktur produk, harga per cabang, katalog, cart, auth | Dosen | Minggu 1-2 |
| **1** | Checkout dasar (tunai/nontunai manual), riwayat transaksi | Mahasiswa (dipandu) | Minggu 3-4 |
| **2** | Member (kartu digital + kode unik) & poin loyalty dasar | Mahasiswa | Minggu 5-6 |
| **3** | Promo engine — **mulai 1 skema dulu** (misal "5 Sip"), baru tambah skema lain jika stabil | Mahasiswa | Minggu 7-8 |
| **4** | Delivery: status manual (diproses/dikirim/selesai) + pembatasan area (Samarinda, Seberang, Palaran) | Mahasiswa | Minggu 9-10 |
| **5** *(lanjutan, pasca-magang atau jika waktu cukup)* | Member Pedagang, real-time tracking penuh, sinkronisasi otomatis dengan Affari, 3 skema promo lainnya | Dosen + tim lanjutan | Setelah evaluasi Fase 0-4 |

**Prinsip fase:** setiap fase harus *stabil dan teruji* sebelum lanjut ke fase berikutnya — bukan mengerjakan semua secara paralel dari awal.

---

## 7. Requirement Fungsional per Fase

### Fase 0 (Dosen)
- FR-01: Sistem dapat menampilkan katalog produk dengan harga sesuai cabang yang dipilih/terdeteksi
- FR-02: Sistem dapat mengimpor data produk dari file CSV/Excel (hasil ekspor dari Affari)
- FR-03: Pengguna dapat registrasi dan login sebagai pembeli
- FR-04: Admin dapat menambah/edit/hapus produk dan harga per cabang lewat panel Filament

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
- FR-14: Pengguna dapat memilih metode pengiriman (kurir internal / pihak ketiga) sesuai area yang didukung
- FR-15: Sistem membatasi pemilihan delivery hanya untuk area Samarinda, Samarinda Seberang, Palaran
- FR-16: Admin/kurir dapat mengubah status pesanan (diproses → dikirim → selesai)
- FR-17: Sistem menerapkan gratis ongkir otomatis jika belanja mencapai minimum tertentu (kurir internal)

---

## 8. Requirement Non-Fungsional

- NFR-01: Sistem harus responsif (mobile-first), karena mayoritas pembeli diasumsikan mengakses lewat HP
- NFR-02: Waktu muat halaman katalog < 3 detik pada koneksi standar
- NFR-03: Data harga per cabang harus konsisten — tidak boleh terjadi race condition saat admin update harga bersamaan dengan transaksi berlangsung
- NFR-04: Setiap perubahan status pesanan harus tercatat dengan timestamp (audit trail sederhana)
- NFR-05: Kapasitas server disesuaikan bertahap — mulai dari estimasi berbasis rata-rata transaksi kasir harian saat ini (perlu data dari klien), bukan asumsi "tidak terbatas" di awal

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

> **Catatan:** Jangan mulai fase terkait sebelum poin klarifikasi di atas dijawab klien — ini mencegah rework besar di tengah pengembangan.

---

## 10. Panduan UI/UX

Mockup awal (homepage/katalog & cart/checkout) sudah dibuat dengan prinsip:
- Ikon selalu disertai label teks (bukan ikon saja) — target pengguna masyarakat umum semua usia
- Search bar menonjol di posisi utama
- Kontrol keranjang (+/-) berukuran besar untuk kemudahan sentuh di HP
- Rincian harga transparan (subtotal, ongkir, diskon, total) untuk membangun kepercayaan
- CTA utama selalu satu per halaman, full-width, warna kontras jelas

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
| — | — | *(belum ada entri)* | — | — |

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
- Starter code homepage & keranjang: `home.blade.php`, `keranjang.blade.php`, `layouts/app.blade.php` (sudah dibuat terpisah)
- Checklist instalasi environment: `Checklist_Starter_Project_Ecommerce_Laravel.md` (sudah dibuat terpisah)
