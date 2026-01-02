<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can list pages', function () {
    Page::factory()->count(3)->create();

    $this->actingAs($this->user)
        ->getJson('/api/backend/pages')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

it('can create a page', function () {
    $data = [
        'title' => 'Test Page',
        'slug' => 'test-page',
        'content' => 'This is a test page content.',
    ];

    $this->actingAs($this->user)
        ->postJson('/api/backend/pages', $data)
        ->assertCreated()
        ->assertJsonPath('data.title', 'Test Page');

    $this->assertDatabaseHas('pages', ['title' => 'Test Page']);
});

it('can show a page', function () {
    $page = Page::factory()->create();

    $this->actingAs($this->user)
        ->getJson("/api/backend/pages/{$page->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $page->id);
});

it('can update a page', function () {
    $page = Page::factory()->create();
    $data = [
        'title' => 'Updated Title',
        'slug' => 'updated-slug',
        'content' => 'Updated content',
    ];

    $this->actingAs($this->user)
        ->putJson("/api/backend/pages/{$page->id}", $data)
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated Title');

    $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Updated Title']);
});

it('can delete a page', function () {
    $page = Page::factory()->create();

    $this->actingAs($this->user)
        ->deleteJson("/api/backend/pages/{$page->id}")
        ->assertOk();

    $this->assertDatabaseMissing('pages', ['id' => $page->id]);
});
