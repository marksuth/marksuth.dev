<?php

declare(strict_types=1);

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can list photos', function () {
    Photo::factory()->count(3)->create();

    $this->actingAs($this->user)
        ->get('/backend/photos')
        ->assertOk()
        ->assertViewIs('backend.photos.index')
        ->assertViewHas('photos');
});

it('can show the create photo form', function () {
    $this->actingAs($this->user)
        ->get('/backend/photos/create')
        ->assertOk()
        ->assertViewIs('backend.photos.manage')
        ->assertViewHas('title', 'Add Photo');
});

it('can show the edit photo form', function () {
    $photo = Photo::factory()->create();

    $this->actingAs($this->user)
        ->get("/backend/photos/{$photo->id}/edit")
        ->assertOk()
        ->assertViewIs('backend.photos.manage')
        ->assertViewHas('photo')
        ->assertViewHas('title', 'Edit Photo');
});

it('can delete a photo', function () {
    $photo = Photo::factory()->create();

    $this->actingAs($this->user)
        ->delete("/backend/photos/{$photo->id}")
        ->assertRedirect('/backend/photos');

    $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
});
