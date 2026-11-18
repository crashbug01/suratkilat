<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Faq;
use App\Models\LetterCategory;
use App\Models\LetterType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('tidak membuat tabel Rilis 3 di sprint 1', function () {
    expect(Schema::hasTable('users'))->toBeFalse()
        ->and(Schema::hasTable('letterheads'))->toBeFalse()
        ->and(Schema::hasTable('saved_letters'))->toBeFalse();
});

it('menolak penghapusan kategori yang masih punya jenis surat', function () {
    $type = LetterType::factory()->create();

    expect(fn () => $type->category->delete())->toThrow(QueryException::class);
});

it('ikut menghapus faq saat jenis surat dihapus', function () {
    $type = LetterType::factory()->create();
    $type->faqs()->create(['question' => 'Apakah gratis?', 'answer' => 'Ya.', 'sort_order' => 1]);

    $type->delete();

    expect(Faq::count())->toBe(0);
});

it('ikut menghapus baris pivot saat artikel dihapus', function () {
    $type = LetterType::factory()->create();
    $article = Article::create(['title' => 'Panduan', 'slug' => 'panduan', 'content' => 'Isi']);
    $article->letterTypes()->attach($type);

    $article->delete();

    expect(DB::table('article_letter_type')->count())->toBe(0);
});

it('menolak slug jenis surat yang kembar', function () {
    LetterType::factory()->create(['slug' => 'surat-izin-sakit']);

    expect(fn () => LetterType::factory()->create(['slug' => 'surat-izin-sakit']))
        ->toThrow(QueryException::class);
});

it('mengubah kolom JSON menjadi array dan hanya mengambil surat terbit', function () {
    $category = LetterCategory::factory()->create();
    $published = LetterType::factory()->for($category, 'category')->create([
        'field_schema' => ['fields' => [['key' => 'nama', 'type' => 'text']]],
    ]);
    LetterType::factory()->for($category, 'category')->unpublished()->create();

    expect($published->fresh()->field_schema['fields'][0]['key'])->toBe('nama')
        ->and(LetterType::published()->count())->toBe(1);
});
