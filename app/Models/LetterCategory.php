<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\LetterCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterCategory extends Model
{
    /** @use HasFactory<LetterCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'sort_order'];

    /** @return HasMany<LetterType, $this> */
    public function letterTypes(): HasMany
    {
        return $this->hasMany(LetterType::class, 'category_id');
    }
}
