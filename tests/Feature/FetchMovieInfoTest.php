<?php

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

it('scrapes title, year, director, and poster from a url and saves to posts', function () {
    Storage::fake('public');

    $html = '<html><body><h1 class="headline-1">Test Movie</h1><a href="/films/year/2023/">2023</a><span class="directorlist"><a href="/director/test-director/">Test Director</a></span><meta property="og:image" content="https://example.com/poster.jpg"></body></html>';

    Http::fake([
        'https://example.com/movie' => Http::response($html, 200),
        'https://example.com/poster.jpg' => Http::response('fake-image-content', 200),
    ]);

    $this->artisan('films:fetch-movie https://example.com/movie --type=23 --collection=3')
        ->expectsOutput('Title: Test Movie')
        ->expectsOutput('Year: 2023')
        ->expectsOutput('Director: Test Director')
        ->expectsOutputToContain('Poster saved to: storage/app/public/films/test-movie-2023.jpg')
        ->assertExitCode(0);

    Storage::disk('public')->assertExists('films/test-movie-2023.jpg');

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Movie',
        'slug' => 'test-movie-2023',
        'post_type_id' => 23,
        'collection_id' => 3,
        'content' => 'REVIEWTEXT',
    ]);

    $post = Post::where('slug', 'test-movie-2023')->first();
    expect($post->meta)->toBe([
        'img_url' => 'test-movie-2023.jpg',
        'director' => 'Test Director',
        'released' => '2023',
        'published' => 1,
        'distant_past' => 1,
        'letterboxd_url' => 'https://example.com/movie',
    ]);
});

it('handles failed requests', function () {
    Http::fake([
        'https://example.com' => Http::response('', 404),
    ]);

    $this->artisan('films:fetch-movie https://example.com')
        ->expectsOutputToContain('Failed to fetch URL. Status: 404')
        ->assertExitCode(1);
});

it('handles missing elements gracefully', function () {
    Http::fake([
        'https://example.com' => Http::response('<html><body></body></html>', 200),
    ]);

    $this->artisan('films:fetch-movie https://example.com')
        ->expectsOutput('Title: N/A')
        ->expectsOutput('Year: N/A')
        ->expectsOutput('Director: N/A')
        ->expectsOutput('Film poster not found.')
        ->assertExitCode(0);
});
