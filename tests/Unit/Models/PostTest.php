<?php

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;

test('post model can be instantiated', function (): void {
    $post = new Post;
    expect($post)->toBeInstanceOf(Post::class);
});

test('post model has correct casts', function (): void {
    $post = new Post;
    expect($post->getCasts())
        ->toHaveKey('meta', 'array')
        ->toHaveKey('published_at', 'datetime');
});

test('post model has post_type relationship', function (): void {
    $post = new Post;
    $relation = $post->post_type();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getRelated())->toBeInstanceOf(PostType::class);
    expect($relation->getForeignKeyName())->toBe('post_type_id');
    expect($relation->getOwnerKeyName())->toBe('id');
});

test('post model has post_collection relationship', function (): void {
    $post = new Post;
    $relation = $post->post_collection();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getRelated())->toBeInstanceOf(PostCollection::class);
    expect($relation->getForeignKeyName())->toBe('collection_id');
    expect($relation->getOwnerKeyName())->toBe('id');
});
