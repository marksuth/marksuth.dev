<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Page extends Model
{
    use HasFactory;

    /**
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:pages,slug',
        'content' => 'required|string',
        'meta' => 'nullable|array',
        'published_at' => 'nullable|date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Scope a query to only include published pages.
     */
    #[Scope]
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('meta->published', '1')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to find a page by its slug.
     */
    #[Scope]
    protected function bySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
