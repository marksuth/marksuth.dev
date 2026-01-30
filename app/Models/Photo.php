<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Photo extends Model
{
    use HasFactory;

    /**
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:photos,slug',
        'content' => 'nullable|string',
        'album_id' => 'nullable|exists:albums,id',
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
        'album_id',
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
     * Get the album that owns the photo.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Scope a query to only include published photos.
     */
    #[Scope]
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('meta->published', '1')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to find a photo by its slug.
     */
    #[Scope]
    protected function bySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
