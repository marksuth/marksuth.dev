<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'post_type_id',
        'collection_id',
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
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'content' => 'required|string',
        'post_type_id' => 'nullable|integer|exists:post_types,id',
        'collection_id' => 'nullable|integer|exists:post_collections,id',
        'meta' => 'nullable|array',
        'published_at' => 'nullable|date',
    ];

    /**
     * Get the searchable array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'meta' => $this->meta,
        ];
    }

    /**
     * Get the post type that owns the post.
     */
    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }

    /**
     * Get the post collection that owns the post.
     */
    public function postCollection(): BelongsTo
    {
        return $this->belongsTo(PostCollection::class, 'collection_id');
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include posts of a given type.
     *
     * @param  int|string  $type
     */
    public function scopeByType(Builder $query, $type): Builder
    {
        if (is_numeric($type)) {
            return $query->where('post_type_id', $type);
        }

        return $query->whereHas('postType', function ($query) use ($type) {
            $query->where('name', $type);
        });
    }

    /**
     * Scope a query to only include posts in a given collection.
     *
     * @param  int|string  $collection
     */
    public function scopeInCollection(Builder $query, $collection): Builder
    {
        if (is_numeric($collection)) {
            return $query->where('collection_id', $collection);
        }

        return $query->whereHas('postCollection', function ($query) use ($collection) {
            $query->where('name', $collection);
        });
    }

    /**
     * Scope a query to search posts by title or content.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Backward compatibility method for post_type().
     * Note: This returns HasOne for backward compatibility with tests.
     */
    public function post_type(): HasOne
    {
        return $this->hasOne(PostType::class, 'id', 'post_type_id');
    }

    /**
     * Backward compatibility method for post_collection().
     * Note: This returns HasOne for backward compatibility with tests.
     */
    public function post_collection(): HasOne
    {
        return $this->hasOne(PostCollection::class, 'id', 'collection_id');
    }
}
