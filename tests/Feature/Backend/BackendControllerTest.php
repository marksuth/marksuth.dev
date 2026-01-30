<?php

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can show the dashboard stats', function () {
    Page::factory()->count(2)->create();
    Post::factory()->count(3)->create();
    Photo::factory()->count(4)->create();

    $this->actingAs($this->user)
        ->get('/backend')
        ->assertOk()
        ->assertViewIs('backend.index')
        ->assertViewHas('stats', [
            'pages' => 2,
            'posts' => 3,
            'photos' => 4,
            'users' => 1,
        ]);
});

it('can list users', function () {
    User::factory()->count(2)->create();

    $this->actingAs($this->user)
        ->get('/backend/users')
        ->assertOk()
        ->assertViewIs('backend.users.index')
        ->assertViewHas('users');
});

it('can create a user', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->actingAs($this->user)
        ->post('/backend/users', $data)
        ->assertRedirect('/backend/users');

    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

it('can show a user', function () {
    $targetUser = User::factory()->create();

    $this->actingAs($this->user)
        ->get("/backend/users/{$targetUser->id}")
        ->assertOk()
        ->assertViewIs('backend.users.show')
        ->assertViewHas('user');
});

it('can update a user', function () {
    $targetUser = User::factory()->create();
    $data = [
        'name' => 'Updated Name',
        'email' => $targetUser->email,
    ];

    $this->actingAs($this->user)
        ->put("/backend/users/{$targetUser->id}", $data)
        ->assertRedirect('/backend/users');

    $this->assertDatabaseHas('users', ['id' => $targetUser->id, 'name' => 'Updated Name']);
});

it('can delete a user', function () {
    $targetUser = User::factory()->create();

    $this->actingAs($this->user)
        ->delete("/backend/users/{$targetUser->id}")
        ->assertRedirect('/backend/users');

    $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
});
