<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->postType = PostType::factory()->create();
});

it('can list posts', function () {
    Post::factory()->count(3)->create(['post_type_id' => $this->postType->id]);

    $this->actingAs($this->user)
        ->get('/backend/posts')
        ->assertOk()
        ->assertViewIs('backend.posts.index')
        ->assertViewHas('posts');
});

it('can show the create post form', function () {
    $this->actingAs($this->user)
        ->get('/backend/posts/create')
        ->assertOk()
        ->assertViewIs('backend.posts.manage')
        ->assertViewHas('title', 'Create Post');
});

it('can store a post', function () {
    $data = [
        'title' => 'New Post',
        'content' => 'Post content',
        'slug' => 'new-post',
        'published_at' => now(),
        'post_type_id' => $this->postType->id,
    ];

    $this->actingAs($this->user)
        ->post('/backend/posts', $data)
        ->assertRedirect('/backend/posts');

    $this->assertDatabaseHas('posts', ['title' => 'New Post']);
});

it('can show the edit post form', function () {
    $post = Post::factory()->create(['post_type_id' => $this->postType->id]);

    $this->actingAs($this->user)
        ->get("/backend/posts/{$post->id}/edit")
        ->assertOk()
        ->assertViewIs('backend.posts.manage')
        ->assertViewHas('post')
        ->assertViewHas('title', 'Edit Post');
});

it('can update a post', function () {
    $post = Post::factory()->create(['post_type_id' => $this->postType->id]);
    $data = [
        'title' => 'Updated Title',
        'content' => 'Updated content',
        'slug' => 'updated-title',
        'published_at' => now(),
        'post_type_id' => $this->postType->id,
    ];

    $this->actingAs($this->user)
        ->put("/backend/posts/{$post->id}", $data)
        ->assertRedirect('/backend/posts');

    $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
});

it('can delete a post', function () {
    $post = Post::factory()->create(['post_type_id' => $this->postType->id]);

    $this->actingAs($this->user)
        ->delete("/backend/posts/{$post->id}")
        ->assertRedirect('/backend/posts');

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
