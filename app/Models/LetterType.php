<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\LetterTypeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterType extends Model
{
    /** @use HasFactory<LetterTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'intro',
        'field_schema',
        'body_template',
        'format_options',
        'guide_content',
        'is_published',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'field_schema' => 'array',
            'format_options' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<LetterType>  $query
     * @return Builder<LetterType>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** @return BelongsTo<LetterCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'category_id');
    }

    /** @return HasMany<Faq, $this> */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order');
    }

    /** @return BelongsToMany<Article, $this> */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_letter_type');
    }
}
