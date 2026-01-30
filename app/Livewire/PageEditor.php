<?php

namespace App\Livewire;

use App\Models\Page;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

final class PageEditor extends Component
{
    use WithFileUploads;

    public ?Page $page = null;

    public $title = '';

    public $slug = '';

    public $content = '';

    public $published_at = '';

    public $is_published = false;

    public $image;

    public function mount(?Page $page = null)
    {
        if ($page && $page->exists) {
            $this->page = $page;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content;
            $this->published_at = $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '';
            $this->is_published = (bool) $page->published_at;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->page) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'slug' => 'required|unique:pages,slug,'.($this->page->id ?? 'NULL'),
            'content' => 'required',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $meta = $this->page ? $this->page->meta : [];

        if ($this->image) {
            $path = $this->image->store('photos', 'public');
            $meta['img_url'] = basename($path);
        }

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'published_at' => $this->is_published ? ($this->published_at ?: now()) : null,
            'meta' => $meta,
        ];

        if ($this->page) {
            $this->page->update($data);
        } else {
            Page::create($data);
        }

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.page-editor');
    }
}
