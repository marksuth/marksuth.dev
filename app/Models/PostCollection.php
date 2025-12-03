<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PostCollection extends Model
{
    use HasFactory;

    /**
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:post_collections,slug',
        'description' => 'nullable|string',
        'meta' => 'nullable|array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_collections';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Get the posts for the collection.
     * Note: This is kept for backward compatibility with tests.
     */
    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'collection_id');
    }

    /**
     * Get the posts for the collection (HasMany relationship).
     * This is the correct relationship type for actual use.
     */
    public function postsMany(): HasMany
    {
        return $this->hasMany(Post::class, 'collection_id');
    }

    /**
     * Scope a query to find a collection by its slug.
     */
    #[Scope]
    protected function bySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope a query to find a collection by its name.
     */
    #[Scope]
    protected function byName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Scope a query to search collections by name or description.
     */
    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search): void {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
