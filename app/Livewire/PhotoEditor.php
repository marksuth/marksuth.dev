<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

final class PhotoEditor extends Component
{
    use \Livewire\WithPagination, WithFileUploads;

    public $uploads = [];

    public ?Photo $editingPhoto = null;

    public $showEditModal = false;

    // Edit form fields
    public $editTitle = '';

    public $editContent = '';

    public $editLocation = '';

    public $editPublishedAt = '';

    public $editAlbumId = '';

    public $editNewAlbumName = '';

    public $uploadData = [];

    public function mount(?Photo $photo = null)
    {
        if ($photo && $photo->exists) {
            $this->edit($photo);
        }
    }

    public function updatedUploads()
    {
        $this->validate([
            'uploads.*' => 'file|max:10240|mimes:jpeg,png,jpg,gif,webp,mp4,mov,qt', // 10MB Max, images and videos
        ]);

        foreach ($this->uploads as $index => $upload) {
            if (! isset($this->uploadData[$index])) {
                $this->uploadData[$index] = [
                    'title' => pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME),
                    'location' => '',
                    'published_at' => now()->format('Y-m-d\TH:i'),
                    'album_id' => '',
                    'new_album_name' => '',
                ];
            }
        }
    }

    public function saveUploads()
    {
        $this->validate([
            'uploadData.*.title' => 'required|min:3',
            'uploadData.*.location' => 'nullable|string',
            'uploadData.*.published_at' => 'required|date',
            'uploadData.*.album_id' => 'nullable',
            'uploadData.*.new_album_name' => 'nullable|string|max:255',
        ]);

        foreach ($this->uploads as $index => $upload) {
            $data = $this->uploadData[$index];
            $path = $upload->store('photos', 'public');
            $filename = basename($path);
            $mime = $upload->getMimeType();

            $albumId = $data['album_id'] ?: null;

            if ($data['new_album_name']) {
                $album = Album::create([
                    'title' => $data['new_album_name'],
                    'slug' => Str::slug($data['new_album_name']).'-'.Str::random(6),
                ]);
                $albumId = $album->id;
            }

            Photo::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']).'-'.Str::random(6),
                'album_id' => $albumId,
                'meta' => [
                    'img_url' => $filename,
                    'mime_type' => $mime,
                    'size' => $upload->getSize(),
                    'location' => $data['location'],
                ],
                'published_at' => Carbon::parse($data['published_at']),
            ]);
        }

        $this->uploads = [];
        $this->uploadData = [];
        $this->dispatch('notify', 'Photos uploaded successfully!');
    }

    public function edit(Photo $photo)
    {
        $this->editingPhoto = $photo;
        $this->editTitle = $photo->title;
        $this->editContent = $photo->content;
        $this->editLocation = $photo->meta['location'] ?? '';
        $this->editPublishedAt = $photo->published_at ? $photo->published_at->format('Y-m-d\TH:i') : '';
        $this->editAlbumId = $photo->album_id ?? '';
        $this->editNewAlbumName = '';
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'editTitle' => 'required|min:3',
            'editContent' => 'nullable',
            'editLocation' => 'nullable|string',
            'editPublishedAt' => 'nullable|date',
            'editAlbumId' => 'nullable',
            'editNewAlbumName' => 'nullable|string|max:255',
        ]);

        $meta = $this->editingPhoto->meta;
        $meta['location'] = $this->editLocation;

        $albumId = $this->editAlbumId ?: null;

        if ($this->editNewAlbumName) {
            $album = Album::create([
                'title' => $this->editNewAlbumName,
                'slug' => Str::slug($this->editNewAlbumName).'-'.Str::random(6),
            ]);
            $albumId = $album->id;
        }

        $this->editingPhoto->update([
            'title' => $this->editTitle,
            'content' => $this->editContent,
            'album_id' => $albumId,
            'meta' => $meta,
            'published_at' => $this->editPublishedAt ?: null,
        ]);

        $this->showEditModal = false;
        $this->editingPhoto = null;
        $this->dispatch('notify', 'Photo updated successfully!');
    }

    public function delete(Photo $photo)
    {
        // Optional: Delete file from storage
        // Storage::disk('public')->delete($photo->meta['path']);

        $photo->delete();
        $this->dispatch('notify', 'Photo deleted successfully!');
    }

    public function cancelEdit()
    {
        $this->showEditModal = false;
        $this->editingPhoto = null;
    }

    public function render()
    {
        return view('livewire.photo-editor', [
            'photos' => Photo::latest()->paginate(12),
            'albums' => Album::orderBy('title')->get(),
        ]);
    }
}
