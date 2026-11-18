<?php

declare(strict_types=1);

use App\Models\LetterCategory;
use App\Models\LetterType;

it('menampilkan beranda dalam bahasa Indonesia', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="id"', false)
        ->assertSee('Surat rapi, selesai dalam hitungan menit.')
        ->assertSee('<link rel="canonical"', false);
});

it('menampilkan kategori berurutan sesuai sort_order', function () {
    LetterCategory::factory()->create(['name' => 'Kategori Kedua', 'sort_order' => 2]);
    LetterCategory::factory()->create(['name' => 'Kategori Pertama', 'sort_order' => 1]);

    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder(['Kategori Pertama', 'Kategori Kedua']);
});

it('menghitung hanya surat yang terbit', function () {
    $category = LetterCategory::factory()->create();
    LetterType::factory()->for($category, 'category')->create();
    LetterType::factory()->for($category, 'category')->unpublished()->create();

    $this->get('/')->assertOk()->assertSee('1 surat');
});

it('memberi petunjuk bila kategori belum punya surat terbit', function () {
    LetterCategory::factory()->create();

    $this->get('/')->assertOk()->assertSee('Surat pertama segera hadir');
});
