<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostType;
use Exception;
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

    public $movie_url = '';

    public $director = '';

    public $released = '';

    public $letterboxd_url = '';

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

            if (isset($post->meta['director'])) {
                $this->director = $post->meta['director'];
            }

            if (isset($post->meta['released'])) {
                $this->released = $post->meta['released'];
            }

            if (isset($post->meta['letterboxd_url'])) {
                $this->letterboxd_url = $post->meta['letterboxd_url'];
            }
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->post) {
            $this->slug = Str::slug($value);
        }
    }

    public function fetchMovieInfo()
    {
        if (empty($this->movie_url)) {
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ])->get($this->movie_url);

            if ($response->failed()) {
                session()->flash('error', 'Failed to fetch movie info.');

                return;
            }

            $html = $response->body();
            $crawler = new \Symfony\Component\DomCrawler\Crawler($html);

            $this->title = $crawler->filter('h1.headline-1')->count() ? $crawler->filter('h1.headline-1')->text() : 'N/A';
            $this->released = $crawler->filter('a[href^="/films/year/"]')->count() ? $crawler->filter('a[href^="/films/year/"]')->first()->text() : 'N/A';
            $this->director = $crawler->filter('span.directorlist a')->count() ? $crawler->filter('span.directorlist a')->text() : 'N/A';

            if ($this->director === 'N/A') {
                $this->director = $crawler->filter('a[href^="/director/"]')->count() ? $crawler->filter('a[href^="/director/"]')->first()->text() : 'N/A';
            }

            $this->slug = Str::slug($this->title.'-'.$this->released);
            $this->letterboxd_url = $this->movie_url;

            $posterUrl = $crawler->filter('meta[property="og:image"]')->count() ? $crawler->filter('meta[property="og:image"]')->attr('content') : null;

            if ($posterUrl) {
                $this->downloadPoster($posterUrl, $this->slug);
            }

        } catch (Exception $e) {
            session()->flash('error', 'An error occurred: '.$e->getMessage());
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
            $path = $this->image->store('photos', 'public');
            $meta['img_url'] = basename($path);
        } elseif ($this->post_type_id === 1 && empty($meta['img_url'])) {
            // If it's a "Watch" type and we fetched movie info, the poster is already saved
            $meta['img_url'] = $this->slug.'.jpg';
        }

        $meta['director'] = $this->director;
        $meta['released'] = $this->released;
        $meta['letterboxd_url'] = $this->letterboxd_url;

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

    protected function downloadPoster(string $url, string $slug)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get($url);

            if ($response->successful()) {
                $path = 'films/'.$slug.'.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $response->body());
                $this->image = null; // Clear any manually uploaded image
                // We'll store the filename in meta during save
            }
        } catch (Exception $e) {
            // Handle error quietly or flash message
        }
    }
}
