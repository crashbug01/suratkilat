<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Hari 3: GET /kategori/{slug} dan GET /{letterType:slug}
// Hari 4: POST /{letterType:slug}/pdf
// Hari 5: GET /sitemap.xml dan halaman statis
// Rute dengan slug dinamis (/{letterType:slug}) harus didaftarkan paling akhir.
