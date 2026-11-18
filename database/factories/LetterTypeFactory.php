<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LetterCategory;
use App\Models\LetterType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<LetterType> */
class LetterTypeFactory extends Factory
{
    protected $model = LetterType::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $title = 'Surat '.fake()->unique()->words(3, true);

        return [
            'category_id' => LetterCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(12),
            'intro' => fake()->paragraph(),
            'field_schema' => ['fields' => []],
            'body_template' => '',
            'format_options' => [
                'has_letterhead' => false,
                'letterhead_default' => false,
                'show_nomor' => false,
                'show_lampiran' => false,
            ],
            'guide_content' => null,
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
