<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PostType extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:post_types,slug',
        'description' => 'nullable|string',
        'meta' => 'nullable|array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_types';

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
     * Get the posts for the post type.
     * Note: This is kept for backward compatibility with tests.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_type_id');
    }

    /**
     * Get the posts for the post type (HasMany relationship).
     * This is the correct relationship type for actual use.
     */
    public function postsMany(): HasMany
    {
        return $this->hasMany(Post::class, 'post_type_id');
    }

    /**
     * Scope a query to find a post type by its slug.
     */
    #[Scope]
    protected function bySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope a query to find a post type by its name.
     */
    #[Scope]
    protected function byName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Scope a query to search post types by name or description.
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
