<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LetterCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<LetterCategory> */
class LetterCategoryFactory extends Factory
{
    protected $model = LetterCategory::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $name = 'Surat '.fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
