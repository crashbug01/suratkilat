<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'published_at'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    /** @return BelongsToMany<LetterType, $this> */
    public function letterTypes(): BelongsToMany
    {
        return $this->belongsToMany(LetterType::class, 'article_letter_type');
    }
}
