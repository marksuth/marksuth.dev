<?php

declare(strict_types=1);

use App\Livewire\PhotoEditor;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders the photo editor component', function () {
    Livewire::test(PhotoEditor::class)
        ->assertStatus(200)
        ->assertSee('Upload Photos');
});

it('can upload a photo with title, location, published_at and new album', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test-photo.jpg');
    $publishedAt = now()->addDays(2)->startOfMinute();

    Livewire::test(PhotoEditor::class)
        ->set('uploads', [$file])
        ->assertSet('uploadData.0.title', 'test-photo')
        ->set('uploadData.0.title', 'Custom Title')
        ->set('uploadData.0.location', 'London, UK')
        ->set('uploadData.0.published_at', $publishedAt->format('Y-m-d\TH:i'))
        ->set('uploadData.0.new_album_name', 'Holiday 2025')
        ->call('saveUploads')
        ->assertDispatched('notify');

    $photo = Photo::where('title', 'Custom Title')->first();
    expect($photo)->not->toBeNull();
    expect($photo->meta['location'])->toBe('London, UK');
    expect($photo->published_at->format('Y-m-d H:i'))->toBe($publishedAt->format('Y-m-d H:i'));
    expect($photo->album)->not->toBeNull();
    expect($photo->album->title)->toBe('Holiday 2025');
});

it('can edit a photo and assign to existing album', function () {
    $album = Album::factory()->create(['title' => 'Existing Album']);
    $photo = Photo::factory()->create([
        'title' => 'Original Title',
        'meta' => ['location' => 'Old Location', 'path' => 'photos/test.jpg'],
    ]);

    Livewire::test(PhotoEditor::class)
        ->call('edit', $photo->id)
        ->set('editAlbumId', $album->id)
        ->call('update')
        ->assertSet('showEditModal', false);

    $photo->refresh();
    expect($photo->album_id)->toBe($album->id);
});

it('can edit a photo and create new album', function () {
    $photo = Photo::factory()->create();

    Livewire::test(PhotoEditor::class)
        ->call('edit', $photo->id)
        ->set('editNewAlbumName', 'New Edit Album')
        ->call('update')
        ->assertSet('showEditModal', false);

    $photo->refresh();
    expect($photo->album->title)->toBe('New Edit Album');
});

it('can edit a photo published_at date', function () {
    $photo = Photo::factory()->create(['published_at' => now()]);
    $newDate = now()->addDays(5)->startOfMinute();

    Livewire::test(PhotoEditor::class)
        ->call('edit', $photo->id)
        ->set('editPublishedAt', $newDate->format('Y-m-d\TH:i'))
        ->call('update');

    $photo->refresh();
    expect($photo->published_at->format('Y-m-d H:i'))->toBe($newDate->format('Y-m-d H:i'));
});

it('can delete a photo', function () {
    $photo = Photo::factory()->create();

    Livewire::test(PhotoEditor::class)
        ->call('delete', $photo->id);

    expect(Photo::find($photo->id))->toBeNull();
});
