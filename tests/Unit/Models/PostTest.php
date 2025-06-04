<?php

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;

test('post model can be instantiated', function () {
    $post = new Post;
    expect($post)->toBeInstanceOf(Post::class);
});

test('post model has correct casts', function () {
    $post = new Post;
    expect($post->getCasts())
        ->toHaveKey('meta', 'array')
        ->toHaveKey('published_at', 'datetime');
});

test('post model has post_type relationship', function () {
    $post = new Post;
    $relation = $post->post_type();

    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class);
    expect($relation->getRelated())->toBeInstanceOf(PostType::class);
    expect($relation->getForeignKeyName())->toBe('id');
    expect($relation->getLocalKeyName())->toBe('post_type_id');
});

test('post model has post_collection relationship', function () {
    $post = new Post;
    $relation = $post->post_collection();

    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class);
    expect($relation->getRelated())->toBeInstanceOf(PostCollection::class);
    expect($relation->getForeignKeyName())->toBe('id');
    expect($relation->getLocalKeyName())->toBe('collection_id');
});

test('post model has searchable method', function () {
    $post = new Post;
    $post->id = 1;
    $post->title = 'Test Post';
    $post->content = 'Test Content';
    $post->meta = ['key' => 'value'];

    $searchableArray = $post->toSearchableArray();

    expect($searchableArray)
        ->toHaveKey('id', 1)
        ->toHaveKey('title', 'Test Post')
        ->toHaveKey('content', 'Test Content')
        ->toHaveKey('meta', ['key' => 'value']);
});
