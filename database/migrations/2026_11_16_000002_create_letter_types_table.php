<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            // Ditolak (restrict) selama kategori masih punya jenis surat.
            $table->foreignId('category_id')
                ->constrained('letter_categories')
                ->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('intro')->nullable();
            $table->json('field_schema')->nullable();
            $table->text('body_template')->nullable();
            $table->json('format_options')->nullable();
            $table->text('guide_content')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            // Untuk katalog dan halaman kategori.
            $table->index(['is_published', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_types');
    }
};
