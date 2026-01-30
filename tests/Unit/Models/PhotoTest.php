<?php

use App\Models\Photo;

test('photo model can be instantiated', function (): void {
    $photo = new Photo;
    expect($photo)->toBeInstanceOf(Photo::class);
});

test('photo model has correct casts', function (): void {
    $photo = new Photo;
    expect($photo->getCasts())
        ->toHaveKey('meta', 'array')
        ->toHaveKey('published_at', 'datetime');
});
