<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCollection extends Model
{
    protected $table = 'post_collections';

    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'collection_id', 'id');
    }
}
