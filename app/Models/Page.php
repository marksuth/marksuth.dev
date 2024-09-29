<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class Page extends Model
{
    use HasFactory;

    /**
     * @var Application|Request|mixed|array
     */
    protected $casts = [
        'meta' => 'array',
        'published_at' => 'datetime',
    ];
}
