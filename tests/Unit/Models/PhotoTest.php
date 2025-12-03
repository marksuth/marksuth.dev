<?php

declare(strict_types=1);

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

test('photo model has searchable method', function (): void {
    $photo = new Photo;
    $photo->id = 1;
    $photo->title = 'Test Photo';
    $photo->content = 'Test Content';

    $searchableArray = $photo->toSearchableArray();

    expect($searchableArray)
        ->toHaveKey('id', 1)
        ->toHaveKey('title', 'Test Photo')
        ->toHaveKey('content', 'Test Content');
});
