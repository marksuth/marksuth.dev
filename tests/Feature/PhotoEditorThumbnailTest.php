<?php

use App\Livewire\PhotoEditor;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('creates a thumbnail in the thumbs folder when a photo is uploaded', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test-photo.jpg');

    Livewire::test(PhotoEditor::class)
        ->set('uploads', [$file])
        ->call('saveUploads')
        ->assertDispatched('notify');

    $photo = Photo::first();
    expect($photo)->not->toBeNull();

    $filename = $photo->meta['img_url'];

    // Check original exists
    Storage::disk('public')->assertExists('photos/'.$filename);

    // Check thumbnail exists
    Storage::disk('public')->assertExists('thumbs/'.$filename);
});
