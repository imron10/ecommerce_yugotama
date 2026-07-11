# UI/UX Design System — E-Commerce Yugotama Mart
### Arah Desain: Modern, Bersih, Ramah Semua Usia (2026)

Dokumen ini jadi acuan visual supaya Mahasiswa B konsisten membangun UI, tanpa harus menebak-nebak warna/ukuran setiap membuat halaman baru.

---

## 1. Prinsip Desain

1. **Trust-first, bukan trendy-first** — supermarket adalah kebutuhan harian, bukan produk lifestyle. Desain harus terasa **kredibel dan familiar**, dengan sentuhan modern lewat tipografi & whitespace, bukan efek visual berlebihan.
2. **Aksesibel untuk semua usia** — kontras tinggi, ukuran teks minimum 14px (bukan 11-12px yang lazim di desain "modern minimalis"), target sentuh tombol minimum 44x44px.
3. **Mobile-first** — 90% keputusan layout diuji dulu di lebar 375-414px, baru disesuaikan ke desktop.
4. **Konsisten, bukan seragam kaku** — komponen re-usable (card produk, badge promo, tombol) dipakai ulang di semua halaman, bukan didesain ulang tiap halaman baru.

---

## 2. Palet Warna

| Token | Hex | Penggunaan |
|---|---|---|
| `primary-700` | `#1E5631` | Warna utama brand — header aksen, tombol penting, harga |
| `primary-500` | `#2F7D46` | Ikon kategori, link, elemen sekunder |
| `primary-100` | `#E7F3EA` | Background section, hover state ringan |
| `accent-500` | `#F2A93B` | Badge promo/diskon, highlight harga coret |
| `accent-100` | `#FDF1DC` | Background banner promo |
| `neutral-900` | `#1A1D1B` | Teks utama |
| `neutral-500` | `#6B7069` | Teks sekunder, placeholder |
| `neutral-100` | `#F5F6F4` | Background halaman, card kosong |
| `danger-500` | `#D64545` | Error, stok habis, hapus item |
| `success-500` | `#2F9E5C` | Konfirmasi berhasil, status "selesai" |

> Hindari gradient berlebihan dan efek glassmorphism tebal — cukup warna flat + shadow tipis untuk depth. Ini menjaga kesan **tepercaya**, bukan "startup demo".

## 3. Tipografi

| Elemen | Font | Ukuran | Weight |
|---|---|---|---|
| Heading besar (judul halaman) | `Plus Jakarta Sans` | 28-32px | 600 |
| Heading kecil (judul section) | `Plus Jakarta Sans` | 18-20px | 600 |
| Body / teks umum | `Inter` | 15-16px | 400 |
| Harga produk | `Inter` | 16-18px | 600 |
| Label kecil (badge, caption) | `Inter` | 12-13px | 500 |

Install via Google Fonts atau bundling lokal:
```html
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
```

> Kenapa `Plus Jakarta Sans` + `Inter`: kombinasi ini populer di produk digital 2025-2026 karena terasa modern tapi tetap sangat mudah dibaca — cocok untuk audiens lintas usia, beda dengan font display yang terlalu bergaya untuk konteks belanja harian.

## 4. Spacing & Radius

- Skala spacing: kelipatan 4px (4, 8, 12, 16, 20, 24, 32...) — pakai default Tailwind, jangan bikin skala custom.
- Radius kartu/tombol: `rounded-xl` (12px) untuk card produk, `rounded-lg` (8px) untuk tombol & input.
- Shadow: gunakan `shadow-sm` untuk card produk (jangan shadow tebal) — kesan bersih, bukan "melayang".

## 5. Komponen Kunci

### Kartu Produk
- Gambar produk (rasio 1:1), nama produk (1 baris, truncate jika panjang), harga bold hijau (`primary-700`), tombol "+ Keranjang" full-width di bawah.
- Jika ada promo: badge oranye (`accent-500`) di pojok kiri-atas gambar, harga asli dicoret di atas harga promo.

### Badge Promo
- Bentuk pill kecil, background `accent-100`, teks `accent-500` bold, contoh: "Promo 5 Sip", "Diskon 20%".

### Tombol Utama (Primary CTA)
- Background `primary-700`, teks putih, height minimum 44px, radius 8px, weight 500.
- Hover: sedikit lebih gelap (`primary-700` → darken 10%), bukan animasi besar.

### Kartu Member Digital
- Desain menyerupai kartu fisik (rasio ~1.6:1), background `primary-700` dengan aksen pola halus, menampilkan: nama member, kode member (font monospace agar mudah dibaca kasir), tipe member (Reguler/Pedagang), saldo poin.

### Status Delivery (Timeline)
- Horizontal stepper 3 tahap: Diproses → Dikirim → Selesai, dengan ikon check pada tahap yang sudah lewat, warna `success-500` untuk tahap aktif/selesai, `neutral-500` untuk tahap belum tercapai.

## 6. Implementasi ke Tailwind Config

Tambahkan token warna di atas ke `tailwind.config.js` (atau `@theme` di `app.css` untuk Tailwind v4):

```css
/* resources/css/app.css - Tailwind v4 */
@theme {
  --color-primary-700: #1E5631;
  --color-primary-500: #2F7D46;
  --color-primary-100: #E7F3EA;
  --color-accent-500: #F2A93B;
  --color-accent-100: #FDF1DC;
  --color-danger-500: #D64545;
  --color-success-500: #2F9E5C;
}
```

Setelah ini, mahasiswa B tinggal pakai class seperti `bg-primary-700`, `text-accent-500`, dst — konsisten di semua halaman tanpa hardcode hex berulang.

## 7. Checklist Implementasi untuk Mahasiswa B

- [ ] Import font `Plus Jakarta Sans` & `Inter`, set sebagai default di `app.css`
- [ ] Tambahkan token warna ke `@theme` (Tailwind v4)
- [ ] Buat 1 komponen Blade reusable untuk kartu produk (`components/product-card.blade.php`) — dipakai ulang di katalog, hasil pencarian, dan produk terkait
- [ ] Buat 1 komponen badge promo reusable
- [ ] Terapkan ke halaman yang sudah ada (`home.blade.php`, `keranjang.blade.php`) — ganti warna hardcoded jadi token di atas
- [ ] Uji tampilan di lebar 375px (HP kecil), 768px (tablet), dan 1280px (desktop)
