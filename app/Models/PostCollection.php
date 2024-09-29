<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCollection extends Model
{
    protected $table = 'post_collections';

    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'collection_id', 'id');
    }
}
