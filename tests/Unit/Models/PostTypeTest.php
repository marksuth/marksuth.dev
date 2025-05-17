<?php

use App\Models\Post;
use App\Models\PostType;

test('post type model can be instantiated', function () {
    $postType = new PostType;
    expect($postType)->toBeInstanceOf(PostType::class);
});

test('post type model has correct casts', function () {
    $postType = new PostType;
    expect($postType->getCasts())
        ->toHaveKey('meta', 'array');
});

test('post type model has correct table name', function () {
    $postType = new PostType;
    expect($postType->getTable())->toBe('post_types');
});

test('post type model has posts relationship', function () {
    $postType = new PostType;
    $relation = $postType->posts();

    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getRelated())->toBeInstanceOf(Post::class);
    expect($relation->getForeignKeyName())->toBe('post_type_id');
    expect($relation->getOwnerKeyName())->toBe('id');
});
