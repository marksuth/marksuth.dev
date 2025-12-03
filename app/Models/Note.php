<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Note extends Model
{
    use HasFactory;

    /**
     * Validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'meta' => 'nullable|array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'meta', // Note: 'meta' column is not in the migration, might need to be added
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
     * Scope a query to search notes by title or content.
     */
    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search): void {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to order notes by most recent.
     */
    #[Scope]
    protected function recent(Builder $query): Builder
    {
        return $query->latest();
    }
}
