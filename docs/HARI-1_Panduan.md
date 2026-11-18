# Panduan Hari 1: Fondasi Proyek (6 jam)

Sprint 1 SuratKilat, MVP Rilis 1. Acuan: Rencana Sprint bagian 4 dan 5, PRD bagian 10 dan 13, ERD bagian 10.4.1.

**Hasil akhir hari ini:** Laravel 13 berjalan, layout dan migrasi siap, CI hijau di GitHub, beranda tampil dengan kategori dari database.

## Ringkasan jadwal

| Jam | Tugas | Durasi | Hasil |
|---|---|---|---|
| 08.00 | S1-01 Instal proyek dan dependensi | 1,5 jam | Laravel 13, Livewire, Tailwind, daisyUI berjalan |
| 09.30 | S1-02 Repo, kualitas kode, CI | 1 jam | Pint, Larastan, Pest hijau di GitHub Actions |
| 10.30 | S1-03 Layout dasar | 1,5 jam | Header, footer, tema, logo |
| 12.00 | Istirahat | | |
| 13.00 | S1-04 Migrasi dan model | 1,25 jam | 5 tabel, 4 model, factory, tes skema |
| 14.15 | S1-05 Rute, beranda, seeder | 0,75 jam | Beranda menampilkan 3 kategori |
| 15.00 | Penutup hari | | Commit, push, CI hijau, catatan |

Total tugas 6 jam. Jam mulai hanya contoh; urutan lebih penting daripada jamnya.

## Isi paket file

Struktur paket meniru struktur proyek Laravel, jadi cukup disalin menimpa proyek (langkah 3.1 dan seterusnya).

```
.github/workflows/ci.yml                          CI: Pint, Larastan, Pest
pint.json, phpstan.neon                           konfigurasi kualitas kode
app/Models/                                       LetterCategory, LetterType, Faq, Article
app/Http/Controllers/HomeController.php
database/migrations/2026_11_16_00000{1..5}_*.php  5 tabel sesuai ERD
database/factories/                               LetterCategoryFactory, LetterTypeFactory
database/seeders/                                 LetterCategorySeeder, DatabaseSeeder
resources/css/app.css                             Tailwind v4 + tema daisyUI "suratkilat" + .paper
resources/views/components/                       layouts/app, site-header, site-footer, logo
resources/views/home.blade.php
routes/web.php
public/favicon.svg
tests/Pest.php, tests/Feature/*Test.php
docs/adr/0001-stack-dan-versi.md
```

---

## S1-01 Instal proyek dan dependensi (1,5 jam)

### 1.1 Cek persyaratan Laravel 13 (15 menit)

Buka dokumentasi resmi di laravel.com (bagian Installation dan Release Notes) dan catat versi PHP minimum serta perubahan yang berdampak. PRD memperkirakan PHP 8.3 ke atas, tetapi angka resminya harus dicek langsung.

```bash
php -v          # harus memenuhi syarat minimum Laravel 13
composer -V
node -v         # disarankan versi LTS terbaru (20 ke atas)
npm -v
git --version
```

Bila PHP belum memenuhi syarat, perbarui sekarang. Bila ada hambatan besar yang tidak terselesaikan dalam 30 menit, pakai versi stabil terdekat dan catat di ADR (risiko pada Rencana Sprint bagian 7).

### 1.2 Instal installer dan buat proyek (15 menit)

```bash
composer global require laravel/installer     # atau: composer global update laravel/installer
laravel new suratkilat
```

Jawaban pada prompt installer:

| Pertanyaan | Pilih |
|---|---|
| Starter kit | **None** (kita tidak memakai starter kit; autentikasi baru di Rilis 3) |
| Framework pengujian | **Pest** |
| Basis data | **SQLite** |
| Jalankan `npm install` dan `npm run build` | **Ya** |

Nama prompt bisa sedikit berbeda antarversi installer. Intinya: tanpa starter kit, Pest, SQLite.

```bash
cd suratkilat
php artisan --version     # harus menampilkan Laravel 13.x
php artisan serve         # cek http://localhost:8000, lalu hentikan dengan Ctrl+C
```

### 1.3 Pasang Livewire dan daisyUI (20 menit)

```bash
composer require livewire/livewire
npm install -D daisyui@latest
```

Template Laravel terbaru sudah memakai Tailwind CSS v4 lewat plugin Vite. Pastikan `vite.config.js` memuat `@tailwindcss/vite`:

```bash
grep -n "tailwindcss" vite.config.js package.json
```

Catatan: konfigurasi daisyUI v5 ada di `resources/css/app.css` (baris `@plugin`), bukan di `tailwind.config.js`. File itu disediakan pada S1-03.

### 1.4 Atur environment (15 menit)

Edit `.env` **dan** `.env.example` (CI memakai `.env.example`):

```env
APP_NAME=SuratKilat
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID
SESSION_DRIVER=file
```

`SESSION_DRIVER=file` diperlukan karena migrasi `users` bawaan (yang juga membuat tabel `sessions`) akan dihapus di bawah.

Edit `config/app.php`:

```php
'timezone' => 'Asia/Jakarta',
```

### 1.5 Bersihkan bawaan yang tidak dipakai (10 menit)

Rencana Sprint menyatakan tabel `users`, `letterheads`, dan `saved_letters` belum dibuat. Migrasi `users` bawaan Laravel juga tidak punya kolom `is_admin` seperti di ERD, jadi akan dibuat ulang di Rilis 3.

```bash
rm database/migrations/0001_01_01_000000_create_users_table.php
```

Biarkan `App\Models\User` dan `UserFactory` (tidak dipakai, tetapi aman). Biarkan migrasi `cache` dan `jobs`.

### 1.6 Pasang paket pengembangan (15 menit)

```bash
composer require --dev larastan/larastan
```

Pint sudah ada bawaan Laravel; Pest sudah terpasang dari installer.

### 1.7 Catat versi di ADR dan commit lokal

Salin `docs/adr/0001-stack-dan-versi.md` dari paket, isi kolom versi dari hasil perintah di atas, lalu:

```bash
git init -b main      # lewati bila installer sudah membuat repo
git add -A && git commit -m "chore: inisialisasi proyek Laravel 13 dengan Livewire dan daisyUI"
```

**Cek selesai S1-01**
- [ ] `php artisan --version` menampilkan Laravel 13.x
- [ ] `composer run dev` (atau `php artisan serve` dan `npm run dev`) menampilkan halaman bawaan
- [ ] ADR berisi versi nyata

### Prompt vibecoding yang berguna (bila ada hambatan versi)

> Saya memakai Laravel 13 dan Tailwind CSS v4 dengan daisyUI v5. Error berikut muncul saat `npm run build`: (tempel pesan galat). Jelaskan penyebabnya sesuai dokumentasi resmi versi tersebut dan beri perbaikan minimal. Jangan menyarankan Tailwind v3 atau file `tailwind.config.js`.

---

## S1-02 Repo GitHub, kualitas kode, dan CI (1 jam)

### 2.1 Buat repo dan hubungkan (10 menit)

Buat repo kosong di GitHub (misalnya `suratkilat`, tanpa README agar tidak bentrok), lalu:

```bash
git remote add origin git@github.com:<username>/suratkilat.git
git push -u origin main
```

Pastikan `.env` tidak ikut ter-commit (`git ls-files | grep "^.env$"` harus kosong).

### 2.2 Salin berkas kualitas kode dan CI (10 menit)

Dari folder paket ke akar proyek:

```bash
cp pint.json phpstan.neon <proyek>/
mkdir -p <proyek>/.github/workflows && cp .github/workflows/ci.yml <proyek>/.github/workflows/
```

Sesuaikan `php-version` di `ci.yml` dengan hasil cek S1-01 (nilai awal 8.4).

### 2.3 Tambahkan skrip Composer (5 menit)

Di `composer.json`, bagian `scripts`, tambahkan:

```json
"lint": "pint --test",
"analyse": "phpstan analyse --memory-limit=1G",
"check": [
    "@lint",
    "@analyse",
    "@php artisan test"
]
```

### 2.4 Jalankan semua pemeriksaan lokal (15 menit)

```bash
vendor/bin/pint            # merapikan; aturan declare_strict_types akan mengubah banyak berkas bawaan
git add -A && git commit -m "style: terapkan Pint dengan strict_types"
composer analyse           # perbaiki temuan; level 5 untuk awal
composer test
```

Pembaruan gaya massal dipisah dalam satu commit sendiri agar riwayat tetap bersih.

### 2.5 Dorong dan pastikan CI hijau (20 menit)

```bash
git add -A && git commit -m "ci: tambah workflow Pint, Larastan, dan Pest"
git push
```

Buka tab **Actions** di GitHub. Bila gagal, baca log langkah yang merah. Penyebab umum: versi PHP tidak sesuai, ekstensi PHP kurang, atau `.env.example` belum berisi `APP_KEY` (workflow menjalankan `key:generate`, jadi aman).

**Cek selesai S1-02**
- [ ] Repo di GitHub berisi commit dari S1-01
- [ ] `composer check` lulus lokal
- [ ] Workflow CI hijau

---

## S1-03 Layout dasar, tema, dan logo (1,5 jam)

### 3.1 Salin berkas (10 menit)

Dari folder paket (struktur ini menimpa berkas bawaan yang bernama sama):

```bash
cp resources/css/app.css <proyek>/resources/css/app.css
cp public/favicon.svg <proyek>/public/favicon.svg
cp -r resources/views/components <proyek>/resources/views/
```

### 3.2 Yang perlu dipahami dari tiap berkas (20 menit)

| Berkas | Peran |
|---|---|
| `resources/css/app.css` | Tailwind v4, plugin daisyUI, tema `suratkilat` (biru tinta `#1b4965`, aksen kuning kilat `#f2a900`), font sistem, dan satu-satunya CSS kustom `.paper` (kartu kertas A4) |
| `components/layouts/app.blade.php` | Kerangka halaman: `lang="id"`, meta description, canonical, favicon, tautan "Lewati ke konten", slot `$slot` |
| `components/site-header.blade.php` | Navbar daisyUI, target sentuh minimal 44 px (`min-h-11`) |
| `components/site-footer.blade.php` | Tautan halaman statis dan penafian "bukan nasihat hukum" (PRD bagian 12) |
| `components/logo.blade.php` | Logo SVG sebaris bersama nama, tanpa permintaan jaringan tambahan |

Pemakaian di halaman mana pun:

```blade
<x-layouts.app title="Judul halaman" description="Deskripsi unik per halaman">
    ...isi...
</x-layouts.app>
```

### 3.3 Sesuaikan identitas (30 menit)

PRD meminta tema dan logo disesuaikan agar tidak terlihat seperti template mentah. Ubah sesuai selera: warna di blok `@plugin "daisyui/theme"`, bentuk logo di `logo.blade.php` dan `favicon.svg`. Jaga kontras teks terhadap latar minimal 4,5:1 (WCAG 2.1 AA).

Font sengaja memakai tumpukan font sistem dulu. Font self-hosted dengan `font-display: swap` dikerjakan di S6-02 (hari 6).

### 3.4 Uji di layar sempit (15 menit)

```bash
npm run dev
```

Buka DevTools, atur lebar 360 px. Periksa: tidak ada scroll horizontal, header tidak patah, tautan mudah disentuh, fokus keyboard terlihat saat menekan Tab.

### 3.5 Commit

```bash
git add -A && git commit -m "feat: layout dasar, header, footer, dan tema daisyUI suratkilat"
```

### Catatan tautan footer

Tautan `/tentang`, `/kontak`, `/kebijakan-privasi`, dan `/syarat-penggunaan` sengaja sudah ada di footer tetapi akan menampilkan 404 sampai S5-04 (hari 5).

**Cek selesai S1-03**
- [ ] Header dan footer tampil di 360 px dan desktop
- [ ] Tema `suratkilat` aktif (tombol primer berwarna biru tinta)
- [ ] `npm run build` berhasil tanpa galat

### Prompt vibecoding (bila ingin menyesuaikan UI)

> Konteks: Laravel 13, Blade, Tailwind CSS v4, daisyUI v5, tanpa React dan tanpa pustaka JS tambahan selain Livewire dan Alpine.js. Aturan: hanya utility Tailwind dan komponen daisyUI; CSS kustom hanya untuk `.paper`; mobile-first mulai 360 px; target sentuh minimal 44 px; teks berbahasa Indonesia baku. Tugas: (jelaskan perubahan). Ubah hanya berkas yang disebut dan jangan menambah dependensi.

---

## S1-04 Migrasi dan model (1,25 jam)

### 4.1 Salin berkas (10 menit)

```bash
cp database/migrations/2026_11_16_*.php <proyek>/database/migrations/
cp app/Models/*.php <proyek>/app/Models/
cp database/factories/*.php <proyek>/database/factories/
cp tests/Pest.php <proyek>/tests/Pest.php
cp tests/Feature/SchemaTest.php <proyek>/tests/Feature/
```

Bila tanggal hari ini berbeda, ganti awalan tanggal pada nama berkas migrasi. Urutan nomor 000001 sampai 000005 harus dipertahankan karena ada ketergantungan kunci asing.

### 4.2 Pemetaan ERD ke migrasi (20 menit)

| Tabel | Poin penting dari ERD |
|---|---|
| `letter_categories` | `slug` unik, `sort_order` |
| `letter_types` | `category_id` **restrict**; `slug` unik; kolom JSON `field_schema` dan `format_options`; indeks gabungan `(is_published, category_id)` |
| `faqs` | `letter_type_id` **cascade**; indeks `(letter_type_id, sort_order)`; tanpa timestamps |
| `articles` | `slug` unik; `published_at` berindeks |
| `article_letter_type` | kunci primer gabungan; kedua FK **cascade** |

Model memakai cast `array` untuk kolom JSON dan `boolean` untuk `is_published`, lalu menyediakan scope `published()`.

### 4.3 Jalankan migrasi (10 menit)

```bash
php artisan migrate:fresh
php artisan tinker --execute="echo implode(', ', array_column(Schema::getTables(), 'name'));"
```

Harus muncul lima tabel aplikasi plus tabel bawaan `cache`, `jobs`, dan `migrations`; **tidak boleh** ada `users`, `letterheads`, atau `saved_letters`.

### 4.4 Jalankan tes skema (15 menit)

```bash
php artisan test --filter=SchemaTest
```

Tes memverifikasi: tabel Rilis 3 belum ada, kategori tidak bisa dihapus bila punya surat (restrict), FAQ dan pivot ikut terhapus (cascade), slug kembar ditolak, cast JSON bekerja.

Catatan: SQLite memberlakukan kunci asing secara bawaan di Laravel. Di MySQL/PostgreSQL pada produksi, perilaku sama karena memakai FK sungguhan.

### 4.5 Tinjau ERD (10 menit)

Bandingkan sekali lagi dengan `ERD_SuratKilat.jpg`: nama tabel, tipe kolom, dan nama relasi. Bila Anda mengubah apa pun, perbarui ERD di PRD agar dokumentasi tetap sama dengan kode.

### 4.6 Commit

```bash
vendor/bin/pint && composer analyse
git add -A && git commit -m "feat: migrasi, model, dan factory untuk katalog surat, FAQ, dan artikel"
```

**Cek selesai S1-04**
- [ ] `migrate:fresh` berhasil
- [ ] `SchemaTest` lulus
- [ ] Larastan tanpa galat

---

## S1-05 Rute, beranda kerangka, dan seeder kategori (0,75 jam)

### 5.1 Salin berkas (5 menit)

```bash
cp routes/web.php <proyek>/routes/web.php
cp app/Http/Controllers/HomeController.php <proyek>/app/Http/Controllers/
cp resources/views/home.blade.php <proyek>/resources/views/
cp database/seeders/*.php <proyek>/database/seeders/
cp tests/Feature/HomePageTest.php tests/Feature/SeederTest.php <proyek>/tests/Feature/
```

Hapus tes contoh bawaan bila ada (`tests/Feature/ExampleTest.php`), karena rute `/` sekarang memakai controller dan tampilan baru.

### 5.2 Seeder kategori (10 menit)

`LetterCategorySeeder` memakai `updateOrCreate` berdasarkan `slug`, jadi aman dijalankan berulang. Tiga kategori awal untuk 10 surat MVP:

| Kategori | Surat MVP |
|---|---|
| Surat Izin | izin sekolah, izin kerja, izin sakit |
| Surat Pekerjaan dan Magang | lamaran kerja, pengunduran diri, permohonan cuti, magang/PKL |
| Surat Administrasi | kuasa, pernyataan, keterangan domisili |

Pengelompokan ini usulan; ubah bila Anda punya pembagian lain, asalkan semua slug tetap konsisten untuk hari 2 sampai 4.

### 5.3 Jalankan dan lihat hasilnya (10 menit)

```bash
php artisan migrate:fresh --seed
composer run dev
```

Buka `http://localhost:8000`. Harus tampil: hero dengan contoh surat berbentuk kertas, bagian Katalog dengan tiga kartu kategori bertuliskan "Surat pertama segera hadir" (surat pertama baru ada di hari 2).

### 5.4 Tes dan commit (20 menit)

```bash
composer check
git add -A && git commit -m "feat: beranda kerangka dengan katalog kategori dan seeder"
```

Rute lain (`/kategori/{slug}`, `/{letterType:slug}`) sudah dicatat sebagai komentar di `routes/web.php` untuk hari 3 dan seterusnya. Rute slug dinamis harus didaftarkan paling akhir agar tidak menimpa `/sitemap.xml` dan halaman statis.

**Cek selesai S1-05**
- [ ] Beranda menampilkan 3 kategori dari database
- [ ] `HomePageTest` dan `SeederTest` lulus

---

## Penutup hari (15 menit)

```bash
composer check
git push
```

- [ ] CI hijau di GitHub Actions
- [ ] Semua perubahan sudah di-commit dengan pesan jelas dan ada di `main`
- [ ] Definition of Done terpenuhi: berfungsi di 360 px dan desktop; lolos Pint, Larastan, dan tes di CI; tidak ada data isian pengguna yang disimpan; teks berbahasa Indonesia baku
- [ ] Catat di ADR bila ada penyimpangan versi
- [ ] Catat realisasi jam per tugas, untuk bahan retrospektif hari 7 dan estimasi Sprint 2

## Bila waktu mepet

Hari 1 tidak punya cadangan terjadwal. Bila terlambat, urutan pemangkasan:

1. Turunkan Larastan ke level 3 dan naikkan lagi di hari 6.
2. Lewati penyesuaian identitas visual (3.3); pakai tema bawaan paket.
3. Tunda `SeederTest` dan tes beranda ke awal hari 2.

Jangan menunda migrasi dan CI: keduanya jadi dasar hari 2 sampai 7.

## Masalah umum

| Gejala | Penyebab dan solusi |
|---|---|
| `Vite manifest not found` | Jalankan `npm run build` atau `npm run dev` |
| Gaya daisyUI tidak muncul | Pastikan `@plugin "daisyui"` ada di `app.css` dan `npm install -D daisyui` sudah dijalankan |
| `no such table: sessions` | `SESSION_DRIVER` belum `file` di `.env` |
| Larastan mengeluh soal generics Eloquent | Pastikan `larastan/larastan` (bukan `nunomaduro/larastan` lama) yang terpasang |
| CI gagal di langkah Pint | Jalankan `vendor/bin/pint` lokal, commit hasilnya |
| Tes gagal `<html lang="id"` | `APP_LOCALE=id` belum ada di `.env.example` |
