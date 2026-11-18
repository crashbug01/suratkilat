<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    // Sesuai ERD, tabel faqs tidak memakai created_at/updated_at.
    public $timestamps = false;

    protected $fillable = ['letter_type_id', 'question', 'answer', 'sort_order'];

    /** @return BelongsTo<LetterType, $this> */
    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }
}
