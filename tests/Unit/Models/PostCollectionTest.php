<?php

use App\Models\Post;
use App\Models\PostCollection;

test('post collection model can be instantiated', function (): void {
    $postCollection = new PostCollection;
    expect($postCollection)->toBeInstanceOf(PostCollection::class);
});

test('post collection model has correct casts', function (): void {
    $postCollection = new PostCollection;
    expect($postCollection->getCasts())
        ->toHaveKey('meta', 'array');
});

test('post collection model has correct table name', function (): void {
    $postCollection = new PostCollection;
    expect($postCollection->getTable())->toBe('post_collections');
});

test('post collection model has posts relationship', function (): void {
    $postCollection = new PostCollection;
    $relation = $postCollection->posts();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getRelated())->toBeInstanceOf(Post::class);
    expect($relation->getForeignKeyName())->toBe('collection_id');
    expect($relation->getOwnerKeyName())->toBe('id');
});
