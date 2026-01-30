<?php

use App\Livewire\PostEditor;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->postType = PostType::factory()->create(['name' => 'Post']);
});

it('can create a post with an image in the photos folder', function () {
    $this->actingAs($this->user);

    $file = UploadedFile::fake()->image('featured.jpg');

    Livewire::test(PostEditor::class)
        ->set('title', 'Test Post')
        ->set('slug', 'test-post')
        ->set('content', 'Some content')
        ->set('post_type_id', $this->postType->id)
        ->set('image', $file)
        ->call('save')
        ->assertRedirect(route('home'));

    $post = Post::where('title', 'Test Post')->first();
    expect($post)->not->toBeNull();
    expect($post->meta['img_url'])->not->toBeNull();
    expect($post->meta['img_url'])->not->toContain('photos/');

    Storage::disk('public')->assertExists('photos/'.$post->meta['img_url']);
});

it('can update a post and change the image', function () {
    $this->actingAs($this->user);

    $post = Post::factory()->create([
        'title' => 'Old Title',
        'meta' => ['img_url' => 'old.jpg'],
    ]);

    $file = UploadedFile::fake()->image('new.jpg');

    Livewire::test(PostEditor::class, ['post' => $post])
        ->set('title', 'New Title')
        ->set('image', $file)
        ->call('save')
        ->assertRedirect(route('home'));

    $post->refresh();
    expect($post->title)->toBe('New Title');
    expect($post->meta['img_url'])->not->toBe('old.jpg');

    Storage::disk('public')->assertExists('photos/'.$post->meta['img_url']);
});
