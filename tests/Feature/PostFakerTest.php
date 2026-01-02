<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can use custom faker post provider', function () {
    $postData = fake()->post();

    expect($postData)->toHaveKeys(['title', 'slug', 'content', 'published_at', 'meta']);
    expect($postData['meta'])->toBe(['published' => '1']);
});

it('can use improved post factory with states', function () {
    $published = Post::factory()->published()->create();
    expect($published->meta['published'])->toBe('1')
        ->and($published->published_at)->not->toBeNull();

    $draft = Post::factory()->draft()->create();
    expect($draft->meta['published'])->toBe('0')
        ->and($draft->published_at)->toBeNull();

    $distantPast = Post::factory()->distantPast()->create();
    expect($distantPast->meta['distant_past'])->toBeTrue();

    $nearFuture = Post::factory()->nearFuture()->create();
    expect($nearFuture->meta['near_future'])->toBeTrue()
        ->and($nearFuture->published_at->isFuture())->toBeTrue();
});
