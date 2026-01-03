<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

it('scrapes h1, release date, and poster from a url', function () {
    Storage::fake('public');

    $html = '<html><body><h1>Test Movie</h1><span class="releasedate">2023-10-27</span><div class="film-poster"><img src="https://example.com/poster.jpg"></div></body></html>';

    Http::fake([
        'https://example.com/movie' => Http::response($html, 200),
        'https://example.com/poster.jpg' => Http::response('fake-image-content', 200),
    ]);

    $this->artisan('app:scrape-url https://example.com/movie')
        ->expectsOutput('H1: Test Movie')
        ->expectsOutput('Release Date: 2023-10-27')
        ->expectsOutputToContain('Poster saved to: storage/app/public/films/poster_')
        ->assertExitCode(0);

    Storage::disk('public')->assertExists('films');
    $files = Storage::disk('public')->files('films');
    expect($files)->toHaveCount(1);
    expect(Storage::disk('public')->get($files[0]))->toBe('fake-image-content');
});

it('handles failed requests', function () {
    Http::fake([
        'https://example.com' => Http::response('', 404),
    ]);

    $this->artisan('app:scrape-url https://example.com')
        ->expectsOutputToContain('Failed to fetch URL. Status: 404')
        ->assertExitCode(1);
});

it('handles missing elements gracefully', function () {
    Http::fake([
        'https://example.com' => Http::response('<html><body></body></html>', 200),
    ]);

    $this->artisan('app:scrape-url https://example.com')
        ->expectsOutput('H1: N/A')
        ->expectsOutput('Release Date: N/A')
        ->expectsOutput('Film poster not found.')
        ->assertExitCode(0);
});
