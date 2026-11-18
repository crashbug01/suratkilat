<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LetterCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = LetterCategory::query()
            ->withCount([
                'letterTypes as published_letter_types_count' => fn (Builder $query) => $query->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->get();

        return view('home', ['categories' => $categories]);
    }
}
