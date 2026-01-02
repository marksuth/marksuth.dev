<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
