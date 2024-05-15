<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    protected $table = 'post_types';

    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_type_id', 'id');
    }
}
