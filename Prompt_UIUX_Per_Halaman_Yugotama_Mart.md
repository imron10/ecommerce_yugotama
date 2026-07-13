# Kumpulan Prompt UI/UX per Halaman — E-Commerce Yugotama Mart

Dokumen ini berisi **prompt siap pakai** untuk setiap halaman sistem, disusun berdasarkan PRD, Design System, dan roadmap fase yang sudah disepakati. Bapak bisa langsung copy-paste tiap prompt ke Claude (atau tools desain lain) untuk menghasilkan mockup detail per halaman, sebelum diserahkan ke mahasiswa sebagai acuan implementasi.

Setiap prompt sudah menyertakan: tujuan halaman, target pengguna, elemen wajib, dan referensi token design system — supaya hasilnya konsisten tanpa perlu dijelaskan ulang tiap kali.

---

## 1. Homepage & Katalog Produk *(Fase 0 — sudah dibuat, referensi pembanding)*

**Tujuan:** Titik masuk utama, tempat pembeli mencari & menjelajah produk.

**Prompt:**
```
Rancang UI/UX halaman homepage & katalog produk untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia (termasuk lansia),
jadi utamakan label teks di samping ikon, ukuran tap target minimal 44px, dan
kontras tinggi.

Elemen wajib:
- Header: logo, search bar menonjol (posisi utama, bukan tersembunyi),
  ikon akun, ikon keranjang dengan badge jumlah item
- Kartu member digital ringkas (kode member, saldo poin) sebagai entry point
  ke halaman profil
- Kategori produk dalam bentuk ikon + label, bisa di-scroll horizontal
- Banner promo aktif (harus dinamis, karena ada 4 skema promo: 5 Sip, Semur,
  Beweekly, Gantung — tampilkan tag nama promo yang sedang aktif)
- Grid produk dengan: gambar, nama, harga (harga sesuai cabang aktif user),
  badge promo + harga coret jika sedang promo, tombol "+ Keranjang" full-width

Gunakan palet warna: primary hijau (#1E5631 / #2F7D46), aksen oranye
(#F2A93B) untuk promo, tipografi Plus Jakarta Sans (heading) + Inter (body).
Mobile-first, breakpoint utama 375px.
```

---

## 2. Halaman Detail Produk

**Tujuan:** Memberi info lengkap 1 produk sebelum pembeli menambah ke keranjang.

**Prompt:**
```
Rancang UI/UX halaman detail produk untuk e-commerce supermarket Yugotama
Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Galeri gambar produk (bisa 1 gambar utama untuk MVP, tidak perlu carousel
  kompleks)
- Nama produk, kategori, harga sesuai cabang yang dipilih user
- Jika produk sedang promo (5 Sip/Semur/Beweekly/Gantung): tampilkan badge
  nama promo, harga asli dicoret, harga promo menonjol, dan sisa waktu promo
  jika relevan
- Info stok sederhana: "Tersedia" / "Stok terbatas" / "Stok habis" — jangan
  tampilkan angka stok pasti (hindari race condition tampilan vs data real)
- Kontrol jumlah (+/-) sebelum tombol "Tambah ke Keranjang"
- Deskripsi produk singkat (opsional, tergantung ketersediaan data dari
  Affari)
- Tombol kembali ke katalog jelas di bagian atas

Gunakan token warna & tipografi yang sama dengan homepage (primary hijau,
aksen oranye untuk promo, Plus Jakarta Sans + Inter). Pastikan tombol utama
("Tambah ke Keranjang") adalah satu-satunya CTA primer di halaman ini.
```

---

## 3. Keranjang & Checkout *(Fase 1 — sudah dibuat, referensi pembanding)*

**Tujuan:** Memastikan pembeli bisa review pesanan dan menyelesaikan transaksi dengan percaya diri.

**Prompt:**
```
Rancang UI/UX halaman keranjang & checkout untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Daftar item keranjang: gambar kecil, nama, harga, kontrol qty (+/-) besar
  dan mudah disentuh
- Pilihan metode pengiriman: "Diantar kurir" (internal, estimasi waktu) atau
  "Ambil sendiri" (gratis, di toko) — beri label jelas + estimasi, bukan
  cuma ikon
- Catatan: sistem TIDAK memakai payment gateway. Untuk metode nontunai,
  alurnya adalah: pembeli pilih "Nontunai" → upload bukti transfer → status
  pesanan "Menunggu verifikasi" sampai admin cek manual. Rancang UI upload
  bukti transfer yang sederhana (drag/tap untuk upload foto)
- Ringkasan harga transparan: subtotal, ongkir (gratis jika minimum belanja
  terpenuhi untuk kurir internal), diskon promo, total akhir
- Validasi area: jika pembeli pilih kurir internal tapi alamat di luar
  Samarinda/Samarinda Seberang/Palaran, tampilkan pesan yang jelas dan
  arahkan ke opsi pihak ketiga
- Tombol "Lanjut ke pembayaran" full-width sebagai satu-satunya CTA utama

Gunakan token warna & tipografi konsisten dengan homepage.
```

---

## 4. Login & Registrasi

**Tujuan:** Onboarding pembeli baru dengan gesekan minimal.

**Prompt:**
```
Rancang UI/UX halaman login dan registrasi untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia, banyak yang
mungkin baru pertama kali belanja online.

Elemen wajib:
- Form registrasi minimal: nama, nomor HP atau email, password — hindari
  kolom berlebihan yang bikin pembeli malas lanjut
- Opsi login dengan nomor HP (umum dipakai pembeli Indonesia) selain email
- Label field jelas di atas input (bukan placeholder yang hilang saat
  diketik — ini penting untuk pengguna lansia)
- Pesan error yang manusiawi, bukan pesan teknis (contoh: "Nomor HP sudah
  terdaftar, silakan login" bukan "Error: duplicate entry")
- Link jelas antara halaman login <-> registrasi
- Tombol utama besar, full-width, kontras tinggi

Gunakan token warna & tipografi konsisten dengan halaman lain (primary
hijau, Plus Jakarta Sans + Inter).
```

---

## 5. Profil Member & Kartu Digital

**Tujuan:** Pusat identitas member — kartu, poin, tipe member.

**Prompt:**
```
Rancang UI/UX halaman profil member untuk e-commerce supermarket Yugotama
Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Kartu member digital menyerupai kartu fisik (rasio ~1.6:1), background
  primary hijau (#1E5631), menampilkan: nama, kode member (font monospace
  agar mudah dibaca/diketik ulang di kasir toko fisik), tipe member
  ("Reguler" atau "Pedagang"), saldo poin
- Penjelasan singkat skema poin: "Belanja Rp100.000 = 1 poin (Rp200)" agar
  pembeli paham cara kerja tanpa harus tanya CS
- Menu navigasi ke: Riwayat Transaksi, Alamat Tersimpan, Pengaturan Akun
- Jika member "Pedagang": tampilkan indikator berbeda (misal badge khusus)
  — catatan: keuntungan spesifik member Pedagang masih perlu klarifikasi
  dari klien, jadi desain harus mudah menyesuaikan setelah info lengkap
  didapat

Gunakan token warna & tipografi konsisten (primary hijau, aksen oranye
untuk badge poin, Plus Jakarta Sans + Inter).
```

---

## 6. Riwayat Transaksi

**Tujuan:** Transparansi histori belanja pembeli.

**Prompt:**
```
Rancang UI/UX halaman riwayat transaksi untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Daftar transaksi terurut dari terbaru, tiap item menampilkan: tanggal,
  jumlah item, total harga, status pesanan (Menunggu verifikasi / Diproses
  / Dikirim / Selesai / Dibatalkan)
- Badge warna berbeda per status agar mudah dipindai sekilas (gunakan token
  warna: success hijau untuk "Selesai", warning oranye untuk "Menunggu
  verifikasi/Diproses", netral abu untuk "Dibatalkan")
- Tap 1 transaksi untuk lihat detail: daftar produk, metode bayar, metode
  kirim, dan tombol lacak pesanan (jika status masih berjalan)
- State kosong yang ramah untuk pembeli baru: "Belum ada transaksi. Yuk
  mulai belanja!" dengan tombol menuju katalog

Gunakan token warna & tipografi konsisten dengan halaman lain.
```

---

## 7. Halaman Promo Aktif

**Tujuan:** Etalase khusus semua promo yang sedang berjalan.

**Prompt:**
```
Rancang UI/UX halaman daftar promo aktif untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Tab atau filter sederhana untuk 4 skema promo: "5 Sip", "Semur" (Senin-
  Selasa), "Beweekly", "Gantung" (gajian) — beri penjelasan singkat 1
  baris per skema agar pembeli paham bedanya
- Grid produk yang sedang promo dengan badge skema promo + harga coret +
  harga promo, konsisten dengan kartu produk di homepage
- Untuk MVP: tampilkan dulu 1 skema promo saja ("5 Sip") sesuai roadmap
  fase, tapi desain layout harus siap menampung skema lain saat
  ditambahkan bertahap

Gunakan token warna: badge promo aksen oranye (#F2A93B), konsisten dengan
kartu produk di halaman lain.
```

---

## 8. Tracking / Status Pesanan

**Tujuan:** Memberi kepastian kepada pembeli soal posisi pesanannya.

**Prompt:**
```
Rancang UI/UX halaman tracking status pesanan untuk e-commerce supermarket
Yugotama Mart. Target pengguna: masyarakat umum semua usia.

Elemen wajib:
- Stepper horizontal 3 tahap: Diproses → Dikirim → Selesai, dengan ikon
  centang pada tahap yang sudah lewat, warna hijau untuk tahap
  aktif/selesai, abu untuk tahap belum tercapai
- Catatan: untuk MVP Fase 4, status masih manual (bukan real-time GPS
  tracking) — desain harus jelas menunjukkan "status terakhir" dan waktu
  update, bukan berpura-pura menampilkan lokasi live yang sebenarnya belum
  ada datanya
- Info metode pengiriman: kurir internal (tampilkan estimasi & area) atau
  pihak ketiga (arahkan ke tracking aplikasi pihak ketiga jika relevan)
- Tombol kontak bantuan jika pembeli ingin tanya soal pesanan

Gunakan token warna: success hijau untuk status selesai, netral abu untuk
status belum tercapai, konsisten dengan warna sistem lain.
```

---

## 9. Panel Admin — Kelola Produk, Harga per Cabang & Promo *(Filament)*

**Tujuan:** Efisiensi kerja admin toko, bukan tampilan customer-facing.

**Prompt:**
```
Rancang struktur resource Filament (bukan desain visual custom, karena
Filament sudah menyediakan komponen admin siap pakai) untuk kelola:
- Produk & kategori (dengan referensi SKU dari sistem Affari)
- Harga per cabang (1 produk bisa beda harga di tiap cabang — pastikan form
  input harga menampilkan semua cabang sekaligus dalam 1 tampilan, bukan
  harus buka form terpisah per cabang)
- Promo (nama skema, produk terkait, harga promo, periode aktif mulai-
  selesai) — beri validasi supaya periode promo tidak tumpang tindih untuk
  produk yang sama
- Verifikasi pembayaran nontunai: tampilkan daftar pesanan "Menunggu
  verifikasi" dengan preview bukti transfer yang diupload pembeli, tombol
  "Verifikasi" / "Tolak" yang jelas
- Update status delivery: dropdown atau tombol aksi untuk ubah status
  pesanan sesuai tahap (Diproses/Dikirim/Selesai)

Fokus pada efisiensi kerja admin harian, bukan estetika — gunakan pola
default Filament (table, form, filter) tanpa kustomisasi berlebihan di
tahap MVP.
```

---

## Cara Pakai Dokumen Ini

1. Untuk tiap halaman, copy prompt yang relevan, tempel ke Claude (atau sesi baru) untuk hasilkan mockup visual detail
2. Setelah mockup disetujui, screenshot/simpan sebagai referensi untuk mahasiswa terkait (terutama Mahasiswa B untuk implementasi Blade + Tailwind)
3. Jika ada perubahan setelah klarifikasi ke klien (misalnya soal member Pedagang atau real-time tracking), update prompt terkait di file ini — supaya jadi acuan yang selalu sinkron dengan PRD terbaru
4. Urutan pengerjaan mockup disarankan mengikuti roadmap fase di PRD: Homepage/Katalog & Login dulu (Fase 0), lalu Cart/Checkout (Fase 1), Member/Profil (Fase 2), Promo (Fase 3), Tracking (Fase 4)
