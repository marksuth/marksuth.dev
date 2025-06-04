<?php

use App\Models\Photo;

test('photo model can be instantiated', function () {
    $photo = new Photo;
    expect($photo)->toBeInstanceOf(Photo::class);
});

test('photo model has correct casts', function () {
    $photo = new Photo;
    expect($photo->getCasts())
        ->toHaveKey('meta', 'array')
        ->toHaveKey('published_at', 'datetime');
});

test('photo model has searchable method', function () {
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
