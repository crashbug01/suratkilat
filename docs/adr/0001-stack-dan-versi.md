# ADR 0001: Stack dan versi dasar

- Status: diterima
- Tanggal: (isi tanggal hari 1)

## Konteks
PRD SuratKilat menetapkan Laravel 13 sebagai stack utama. Detail persyaratan
(versi PHP, paket kompatibel) harus diverifikasi sebelum pengembangan dimulai.

## Keputusan
| Komponen | Pilihan | Versi terpasang |
|---|---|---|
| PHP | 8.3 atau lebih baru | (isi dari `php -v`) |
| Laravel | 13.x | (isi dari `php artisan --version`) |
| Livewire | versi stabil terbaru | (isi dari `composer show livewire/livewire`) |
| Tailwind CSS | v4 lewat Vite | (isi dari `npm ls tailwindcss`) |
| daisyUI | v5 | (isi dari `npm ls daisyui`) |
| Pengujian | Pest | (isi dari `vendor/bin/pest --version`) |
| Analisis statis | Larastan, level 5 (naik bertahap) | (isi) |
| Basis data lokal dan CI | SQLite | - |

## Penyimpangan dari PRD
(Tulis di sini bila ada paket yang belum kompatibel dan versi pengganti yang dipakai.
Bila tidak ada penyimpangan, tulis: tidak ada.)

## Konsekuensi
- Tabel `users`, `letterheads`, dan `saved_letters` sengaja belum dibuat (Rilis 3).
- `SESSION_DRIVER=file` dipakai sementara karena tabel `sessions` ikut dihapus bersama
  migrasi `users` bawaan Laravel.
