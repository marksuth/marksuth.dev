<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('downloads images for posts in collection 3', function () {
    Storage::fake('public');
    Http::fake([
        'https://example.com/image.jpg' => Http::response('fake-image-content', 200),
    ]);

    $post = Post::factory()->create([
        'collection_id' => 3,
        'slug' => 'test-film',
        'meta' => [
            'img_url' => 'https://example.com/image.jpg',
        ],
    ]);

    $this->artisan('app:download-film-images')
        ->assertSuccessful()
        ->expectsOutput('Found 1 posts.')
        ->expectsOutput('Done.');

    Storage::disk('public')->assertExists('films/test-film.jpg');

    $post->refresh();
    expect($post->meta['img_url'])->toBe('films/test-film.jpg');
});

it('skips posts not in collection 3', function () {
    Storage::fake('public');

    Post::factory()->create([
        'collection_id' => 1,
        'meta' => [
            'img_url' => 'https://example.com/other.jpg',
        ],
    ]);

    $this->artisan('app:download-film-images')
        ->expectsOutput('No posts found for collection id 3.');

    Storage::disk('public')->assertMissing('films/other.jpg');
});

it('skips posts already having local images', function () {
    Storage::fake('public');

    $post = Post::factory()->create([
        'collection_id' => 3,
        'meta' => [
            'img_url' => 'films/already-local.jpg',
        ],
    ]);

    $this->artisan('app:download-film-images')
        ->assertSuccessful();

    $post->refresh();
    expect($post->meta['img_url'])->toBe('films/already-local.jpg');
    Storage::disk('public')->assertMissing('films/already-local.jpg'); // Missing because it was never downloaded
});
