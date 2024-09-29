<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PostType extends Model
{
    /**
     * @var Application|Request|mixed|array
     */
    protected $table = 'post_types';

    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_type_id', 'id');
    }
}
