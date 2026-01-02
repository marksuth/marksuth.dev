<?php

declare(strict_types=1);

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can search posts using scout database engine', function () {
    Post::factory()->create([
        'title' => 'Unique Laravel Post',
        'content' => 'This is some special content about Laravel.',
    ]);

    Post::factory()->create([
        'title' => 'Other Post',
        'content' => 'Generic content.',
    ]);

    $results = Post::search('Unique Laravel')->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->title)->toBe('Unique Laravel Post');
});

it('can search photos using scout database engine', function () {
    Photo::factory()->create([
        'title' => 'Stunning Sunset Photo',
        'content' => 'A beautiful sunset captured in Malibu.',
    ]);

    Photo::factory()->create([
        'title' => 'City Lights',
        'content' => 'Night photography of New York.',
    ]);

    $results = Photo::search('Stunning Sunset')->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->title)->toBe('Stunning Sunset Photo');
});
