<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

final class PostEditor extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public $title = '';

    public $slug = '';

    public $content = '';

    public $published_at = '';

    public $post_type_id = '';

    public $is_published = false;

    public $image;

    public function mount(?Post $post = null)
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->content = $post->content;
            $this->post_type_id = $post->post_type_id;
            $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '';
            $this->is_published = (bool) $post->published_at;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->post) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'slug' => 'required|unique:posts,slug,'.($this->post->id ?? 'NULL'),
            'content' => 'required',
            'post_type_id' => 'required|exists:post_types,id',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $meta = $this->post ? $this->post->meta : [];

        if ($this->image) {
            $path = $this->image->store('posts', 'public');
            $meta['image'] = $path;
        }

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'post_type_id' => $this->post_type_id,
            'published_at' => $this->is_published ? ($this->published_at ?: now()) : null,
            'meta' => $meta,
        ];

        if ($this->post) {
            $this->post->update($data);
        } else {
            Post::create($data);
        }

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.post-editor', [
            'postTypes' => PostType::all(),
        ]);
    }
}
