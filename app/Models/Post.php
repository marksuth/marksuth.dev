<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    public function post_type(): HasOne
    {
        return $this->hasOne(PostType::class, 'id', 'post_type_id');
    }

    public function post_collection(): HasOne
    {
        return $this->hasOne(PostCollection::class, 'id', 'collection_id');
    }
}
