<?php

use App\Livewire\PostEditor;
use App\Models\PostType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('fetches movie info when movie_url is provided and fetch button is clicked', function () {
    Storage::fake('public');

    $postType = PostType::factory()->create([
        'id' => 1,
        'name' => 'Watch',
    ]);

    $html = '<html><body><h1 class="headline-1">Test Movie</h1><a href="/films/year/2023/">2023</a><span class="directorlist"><a href="/director/test-director/">Test Director</a></span><meta property="og:image" content="https://example.com/poster.jpg"></body></html>';

    Http::fake([
        'https://example.com/movie' => Http::response($html, 200),
        'https://example.com/poster.jpg' => Http::response('fake-image-content', 200),
    ]);

    Livewire::test(PostEditor::class)
        ->set('post_type_id', 1)
        ->set('movie_url', 'https://example.com/movie')
        ->call('fetchMovieInfo')
        ->assertSet('title', 'Test Movie')
        ->assertSet('released', '2023')
        ->assertSet('director', 'Test Director')
        ->assertSet('slug', 'test-movie-2023')
        ->assertSet('letterboxd_url', 'https://example.com/movie');

    Storage::disk('public')->assertExists('films/test-movie-2023.jpg');
});

it('saves movie info meta-data when saving the post', function () {
    Storage::fake('public');
    PostType::factory()->create([
        'id' => 1,
        'name' => 'Watch',
    ]);

    Livewire::test(PostEditor::class)
        ->set('post_type_id', 1)
        ->set('title', 'Test Movie')
        ->set('slug', 'test-movie')
        ->set('content', 'Test Content')
        ->set('director', 'Test Director')
        ->set('released', '2023')
        ->set('letterboxd_url', 'https://example.com/movie')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('home'));

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Movie',
        'slug' => 'test-movie',
        'post_type_id' => 1,
    ]);

    $post = App\Models\Post::where('slug', 'test-movie')->first();
    expect($post->meta)->toMatchArray([
        'director' => 'Test Director',
        'released' => '2023',
        'letterboxd_url' => 'https://example.com/movie',
    ]);
});
