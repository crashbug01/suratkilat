<?php

declare(strict_types=1);

use App\Models\LetterCategory;
use Database\Seeders\DatabaseSeeder;

it('mengisi kategori dan aman dijalankan berulang', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(LetterCategory::count())->toBe(3)
        ->and(LetterCategory::orderBy('sort_order')->pluck('slug')->all())
        ->toBe(['surat-izin', 'surat-pekerjaan', 'surat-administrasi']);
});
