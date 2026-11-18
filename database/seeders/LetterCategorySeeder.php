<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LetterCategory;
use Illuminate\Database\Seeder;

class LetterCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Surat Izin',
                'slug' => 'surat-izin',
                'description' => 'Izin tidak masuk sekolah, kerja, atau karena sakit.',
            ],
            [
                'name' => 'Surat Pekerjaan dan Magang',
                'slug' => 'surat-pekerjaan',
                'description' => 'Lamaran kerja, pengunduran diri, permohonan cuti, dan pengajuan magang atau PKL.',
            ],
            [
                'name' => 'Surat Administrasi',
                'slug' => 'surat-administrasi',
                'description' => 'Surat kuasa, surat pernyataan, dan surat keterangan domisili.',
            ],
        ];

        foreach ($categories as $index => $category) {
            LetterCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['sort_order' => $index + 1],
            );
        }
    }
}
