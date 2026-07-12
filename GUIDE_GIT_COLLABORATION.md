# Panduan Git & Kolaborasi GitHub — Yugotama Mart

> **Repo:** `https://github.com/imron10/ecommerce_yugotama.git`
> **Peran:** 1 Dosen (pemilik repo) + 3 Mahasiswa (kontributor)

---

## 📖 Daftar Isi

1. [Apa itu Git & GitHub?](#1-apa-itu-git--github)
2. [Workflow Kolaborasi Tim](#2-workflow-kolaborasi-tim)
3. [Branching Strategy (Strategi Cabang)](#3-branching-strategy)
4. [Panduan Git untuk Mahasiswa (Lengkap dengan Perintah)](#4-panduan-git-untuk-mahasiswa)
5. [Cara Setup Awal Setiap Mahasiswa](#5-cara-setup-awal-setiap-mahasiswa)
6. [Skenario Kerja Per Fase](#6-skenario-kerja-per-fase)
7. [Cara Mengatasi Konflik](#7-cara-mengatasi-konflik)
8. [FAQ & Troubleshooting](#8-faq--troubleshooting)

---

## 1. Apa itu Git & GitHub?

### Git (Sistem Kontrol Versi)

Git adalah sistem yang **melacak setiap perubahan** pada kode. Bayangkan seperti "save point" di game — kamu bisa:

- ✅ Melihat siapa yang mengubah apa dan kapan
- ✅ Kembali ke versi sebelumnya jika ada error
- ✅ Bekerja di fitur sendiri tanpa mengganggu orang lain
- ✅ Menggabungkan pekerjaan semua anggota tim

### GitHub (Platform Hosting)

GitHub adalah tempat **menyimpan repositori Git di internet**. Fungsinya:

- ✅ Semua anggota tim bisa download (clone) kode terbaru
- ✅ Bisa membuat Pull Request untuk review kode sebelum digabung
- ✅ Menyimpan history proyek secara online (backup aman)
- ✅ Bisa lihat perkembangan proyek lewat web

### Istilah Penting

| Istilah | Arti Sederhana | Perintah |
|---|---|---|
| **Repository (repo)** | Folder proyek yang dilacak Git | `git init` |
| **Clone** | Download repo dari GitHub ke laptop | `git clone <url>` |
| **Commit** | Simpan perubahan (seperti save point) | `git commit -m "pesan"` |
| **Branch** | Cabang — jalur kerja terpisah | `git branch`, `git checkout` |
| **Merge** | Gabungkan perubahan dari branch lain | `git merge <branch>` |
| **Pull** | Ambil perubahan terbaru dari GitHub | `git pull` |
| **Push** | Kirim perubahan lokal ke GitHub | `git push` |
| **Pull Request (PR)** | Minta review sebelum menggabungkan kode | (via GitHub web) |

---

## 2. Workflow Kolaborasi Tim

### 📋 Alur Kerja Mingguan

```
MINGGU INI:
    │
    ├── 1. Dosen assign task ke setiap mahasiswa
    │      (misal: "Mahasiswa A buat fitur member")
    │
    ├── 2. Mahasiswa bikin branch sendiri
    │      (misal: fitur/member-database)
    │
    ├── 3. Mahasiswa coding di branch masing-masing
    │      → commit bertahap (jangan 1 commit besar)
    │
    ├── 4. Selesai? → Pull Request ke GitHub
    │      (minta dosen review)
    │
    ├── 5. Dosen review → request perubahan (jika perlu)
    │
    └── 6. Dosen merge ke branch main
          (kode resmi tergabung)
```

### 🖼️ Visual Alur Branch

```
main  ──●────────────●────────────●─────────▶
         \          / \          /
          \        /   \        /
fitur-A    ─●──●─●     \      /
                         \    /
fitur-B                ─●──●─●
```

> **Prinsip:** `main` adalah kode **stabil dan siap pakai**. Semua pengembangan dilakukan di **branch terpisah**, baru digabungkan setelah direview.

---

## 3. Branching Strategy

### Struktur Branch

```
main (produksi — kode stabil)
│
├── fase-1-checkout/        ← Mahasiswa C: checkout & transaksi
├── fase-1-riwayat/         ← Mahasiswa A: backend riwayat
│
├── fase-2-member/          ← Mahasiswa A: member & poin
├── fase-2-ui-member/       ← Mahasiswa B: tampilan kartu member
│
├── fase-3-promo-engine/    ← Mahasiswa A: engine promo
├── fase-3-ui-promo/        ← Mahasiswa B: tampilan promo
│
└── fase-4-delivery/        ← Mahasiswa C: delivery & status
```

### Aturan Penamaan Branch

| Prefix | Contoh | Digunakan untuk |
|---|---|---|
| `fase-1/` | `fase-1/checkout` | Fitur Fase 1 |
| `fase-2/` | `fase-2/member-poin` | Fitur Fase 2 |
| `fix/` | `fix/harga-cabang` | Perbaikan bug |
| `docs/` | `docs/update-readme` | Update dokumentasi |

### Aturan Penting

1. ❌ **Jangan commit langsung ke `main`** — selalu buat branch dulu
2. ✅ **Commit sedikit tapi sering** — setiap selesai fungsi kecil, commit
3. ✅ **Commit message jelas** — `"Tambah fitur upload bukti bayar"` bukan `"update"`
4. ✅ **Pull sebelum mulai coding** — ambil perubahan terbaru dari tim lain
5. ✅ **Buat Pull Request** — minta review dosen sebelum merge ke main

---

## 4. Panduan Git untuk Mahasiswa (Lengkap)

### 4.1 Pertama Kali — Clone Repo

Hanya sekali di awal. Setiap mahasiswa jalankan:

```bash
# Buka terminal, pindah ke folder project
cd /Users/user/Documents/Project

# Download repo dari GitHub ke laptop
git clone https://github.com/imron10/ecommerce_yugotama.git

# Masuk ke folder hasil clone
cd ecommerce_yugotama

# Install dependencies (butuh composer & npm)
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database di file .env (sesuaikan dengan MAMP masing-masing)
# DB_DATABASE=ecommerce_yugotama
# DB_USERNAME=root
# DB_PASSWORD=root

# Jalankan migrasi + seed data awal
php artisan migrate --seed
```

### 4.2 Setiap Hari Mulai Coding

```bash
# 1. Masuk ke folder project
cd ecommerce_yugotama

# 2. Ambil perubahan terbaru dari GitHub
git checkout main        # pindah ke branch main dulu
git pull origin main     # ambil update terbaru

# 3. Buat branch baru untuk fitur hari ini
git checkout -b fase-1/checkout

# 4. Coding... selesai beberapa fungsi? Commit!
git add .
git commit -m "Tambah model Transaksi dan migration"

# 5. Coding lagi... selesai bagian lain? Commit lagi!
git add app/Http/Controllers/CheckoutController.php
git commit -m "Buat controller checkout dasar"

# 6. Selesai semua? Push ke GitHub
git push origin fase-1/checkout

# 7. Buka GitHub → buat Pull Request
```

### 4.3 Git Status — Cek Kondisi Repo

```bash
# Lihat file yang berubah
git status

# Lihat branch saat ini
git branch

# Lihat history commit
git log --oneline

# Lihat perbedaan sebelum commit
git diff
```

### 4.4 Jika Ada Perubahan dari Tim Lain

```bash
# Sebelum lanjut coding, ambil update dulu
git checkout main
git pull origin main

# Gabungkan update ke branch kamu
git checkout fase-1/checkout
git merge main

# Selesaikan konflik (jika ada) — lihat bagian 7
```

---

## 5. Cara Setup Awal Setiap Mahasiswa

Sebagai pemilik repo (imron10), kamu perlu **mengundang mahasiswa sebagai kolaborator**.

### Langkah 1 — Undang Kolaborator

1. Buka **https://github.com/imron10/ecommerce_yugotama/settings/access**
2. Klik **Collaborators** → **Add people**
3. Masukkan **username GitHub** atau **email** masing-masing mahasiswa
4. Klik **Add to this repository**

> Setiap mahasiswa akan menerima undangan via email — mereka harus **accept invitation**.

### Langkah 2 — Assign Task Mingguan

| Minggu | Mahasiswa A (Backend) | Mahasiswa B (Frontend) | Mahasiswa C (Integrasi) |
|---|---|---|---|
| **3-4** | Buat model & migration Transaksi, riwayat | Tampilan keranjang & checkout | Controller checkout, upload bukti |
| **5-6** | Model Member & Poin, hitung otomatis | Halaman kartu member digital | Verifikasi bayar, status pesanan |
| **7-8** | Engine promo (5 Sip), CRUD admin promo | Tampilan promo di katalog | — |
| **9-10** | — | — | Delivery, tracking status, ongkir |

### Langkah 3 — Review & Merge

1. Mahasiswa bikin branch → push → buat Pull Request
2. Kamu review di GitHub (lihat tab **Pull requests**)
3. Klik **Files changed** → lihat perubahannya
4. Klik **Review changes** → pilih:
   - **Comment** — kasih saran
   - **Approve** — setuju
   - **Request changes** — minta diperbaiki
5. Kalau sudah ok, klik **Merge pull request** → **Confirm merge**

---

## 6. Skenario Kerja Per Fase

### 🎯 Skenario 1: Mahasiswa C Mengerjakan Checkout (Fase 1)

1. **Clone repo** (pertama kali)
2. `git checkout main && git pull origin main`
3. `git checkout -b fase-1/checkout`
4. Buat file migration transaksi → `git add . && git commit -m "Tambah migration transaksi"`
5. Buat model Transaksi → `git add . && git commit -m "Tambah model Transaksi"`
6. Buat controller checkout → `git add . && git commit -m "Buat CheckoutController"`
7. Buat view blade checkout → `git add . && git commit -m "Tambah halaman checkout"`
8. `git push origin fase-1/checkout`
9. Buka GitHub → **Pull Requests** → **New pull request**
10. Kirim link PR ke dosen via WhatsApp

### 🎯 Skenario 2: Mahasiswa A Ingin Menggabungkan Kode dari Main

```bash
# Saat di branch fitur-member
git checkout main
git pull origin main
git checkout fitur-member
git merge main
# Selesaikan konflik (jika ada)
git push origin fitur-member
```

### 🎯 Skenario 3: Error — Lupa Switch Branch

```bash
# Misal kamu lagi di branch main, padahal harusnya di branch fitur
# Kamu sudah edit file, tapi belum commit

git status                      # lihat file yang berubah
git stash                       # simpan sementara perubahan
git checkout -b fitur-saya      # bikin branch baru
git stash pop                   # keluarkan perubahan yang tadi disimpan
git add .
git commit -m "Fitur selesai"
```

---

## 7. Cara Mengatasi Konflik

### Apa Itu Konflik?

Konflik terjadi ketika **dua orang mengubah baris yang sama** di file yang sama. Git bingung harus pakai versi siapa.

### Contoh Konflik

```
<<<<<<< HEAD
$harga = $produk->harga * 1.1;  // Mahasiswa A: +10%
=======
$harga = $produk->harga * 1.15; // Mahasiswa C: +15%
>>>>>>> fase-1-checkout
```

### Cara Menyelesaikan

```bash
# 1. Cari file yang konflik
git status
# Output: both modified: app/Http/Controllers/ProdukController.php

# 2. Buka file tersebut di editor
#    Cari tanda <<<<<<< ====== >>>>>>>

# 3. Putuskan versi mana yang benar, lalu hapus:
#    - Baris <<<<<<< HEAD
#    - Baris =======
#    - Baris >>>>>>> nama-branch
#    - Rapikan kodenya

# 4. Setelah diperbaiki:
git add app/Http/Controllers/ProdukController.php
git commit -m "Selesaikan konflik merge"
git push
```

### Tips Menghindari Konflik

| Tips | Penjelasan |
|---|---|
| ✅ **Pisahkan file kerja** | Mahasiswa A kerja di `app/Models/`, B kerja di `resources/views/`, C kerja di `app/Http/Controllers/` |
| ✅ **Commit & push setiap hari** | Jangan menimbun perubahan berhari-hari |
| ✅ **Pull sebelum mulai** | Ambil perubahan terbaru dari tim lain dulu |
| ✅ **Beri tahu tim** | "Saya mau edit file X" — koordinasi via grup WhatsApp |
| ❌ **Jangan edit file .env** | File .env tidak di-push, tidak akan konflik |
| ❌ **Jangan edit file package.json barengan** | Kalau dua orang nambah package, bisa konflik |

---

## 8. FAQ & Troubleshooting

### Q: Git minta username/password waktu push?

Pakai token, bukan password biasa:
```bash
Username: imron10
Password: <paste personal access token>
```

Buat token di: **https://github.com/settings/tokens**

### Q: Lupa pull sebelum mulai coding, udah terlanjur edit?

```bash
git stash                     # simpan sementara
git pull origin main          # ambil update
git stash pop                 # kembalikan perubahan kamu
# Selesaikan konflik (jika ada)
```

### Q: Commit message salah?

```bash
git commit --amend -m "Pesan yang benar"
```

> ⚠️ Hanya lakukan jika belum di-push! Kalau sudah di-push, jangan diubah.

### Q: Mau batalkan perubahan yang belum di-commit?

```bash
git checkout -- nama-file.php     # batalkan 1 file
git restore .                      # batalkan semua perubahan (Laravel 9+)
```

### Q: Mau lihat history lengkap?

```bash
git log --oneline --graph --all
```

### Q: Lupa branch apa yang pernah dibuat?

```bash
git branch -a    # lihat semua branch (lokal + remote)
```

### Q: Cara download (clone) ulang tanpa kehilangan data?

```bash
# Simpan dulu file-file penting (misal .env)
cp .env .env.backup

# Clone ulang
cd ..
rm -rf ecommerce_yugotama
git clone https://github.com/imron10/ecommerce_yugotama.git

# Kembalikan .env
cp .env.backup ecommerce_yugotama/.env
cd ecommerce_yugotama
composer install
npm install
```

---

## 🚀 Ringkasan Perintah Penting

| Situasi | Perintah |
|---|---|
| Download repo pertama kali | `git clone <url>` |
| Ambil update terbaru | `git pull origin main` |
| Buat branch baru | `git checkout -b nama-branch` |
| Cek status | `git status` |
| Commit perubahan | `git add .` lalu `git commit -m "pesan"` |
| Kirim ke GitHub | `git push origin nama-branch` |
| Ganti branch | `git checkout nama-branch` |
| Gabung perubahan | `git merge nama-branch` |
| Lihat history | `git log --oneline` |
| Buat Pull Request **(di website GitHub)** | Buka repo → Pull Requests → New |

---

## 📌 Checklist Setup Awal Mahasiswa

- [ ] Buat akun GitHub (https://github.com/signup)
- [ ] Install Git di laptop (https://git-scm.com/downloads)
- [ ] Setup Git:
  ```bash
  git config --global user.name "Nama Mahasiswa"
  git config --global user.email "email@contoh.com"
  ```
- [ ] Install Composer (https://getcomposer.org)
- [ ] Install Node.js & npm (https://nodejs.org)
- [ ] Setup MAMP / Laravel Herd / XAMPP
- [ ] Clone repo: `git clone https://github.com/imron10/ecommerce_yugotama.git`
- [ ] Setuju undangan kolaborasi (cek email GitHub)
- [ ] Jalankan `composer install && npm install`
- [ ] Copy `.env.example` ke `.env` → setup database
- [ ] `php artisan migrate --seed`

---

> **Dokumen ini disusun untuk memandu kolaborasi tim pengembangan Yugotama Mart.**
> Jika ada pertanyaan, tanyakan ke dosen pembimbing atau lihat dokumentasi GitHub: https://docs.github.com
