<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class PageController extends Controller
{
    /**
     * Display the home page with various content sections.
     */
    public function home(): View
    {
        $posts = Cache::remember('home.posts', now()->addMinutes(30), function () {
            return Post::query()
                ->select(['id', 'title', 'slug', 'post_type_id', 'content', 'published_at'])
                ->with('postType')
                ->whereIn('post_type_id', [1, 14])
                ->published()
                ->current()
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        $activities = Cache::remember('home.activities', now()->addMinutes(30), function () {
            return Post::query()
                ->select(['id', 'title', 'slug', 'post_type_id', 'published_at'])
                ->with('postType')
                ->whereNotIn('post_type_id', [1, 14, 28])
                ->published()
                ->current()
                ->latest('published_at')
                ->take(9)
                ->get();
        });

        $watched = Cache::remember('home.watched', now()->addMinutes(30), function () {
            return Post::query()
                ->with(['postType', 'postCollection'])
                ->where('post_type_id', '23')
                ->where('collection_id', '3')
                ->published()
                ->current()
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        $photos = Cache::remember('home.photos', now()->addMinutes(30), function () {
            return Photo::query()
                ->select(['id', 'title', 'slug', 'meta', 'published_at'])
                ->published()
                ->latest('published_at')
                ->take(6)
                ->get();
        });

        $latest_photo = Cache::remember('home.latest_photo', now()->addMinutes(10), function () {
            return Photo::query()
                ->select(['id', 'title', 'slug', 'meta', 'published_at'])
                ->published()
                ->where('published_at', '>=', now()->subDay())
                ->latest('published_at')
                ->first();
        });

        return view('pages.home', compact('posts', 'activities', 'watched', 'photos', 'latest_photo'));
    }

    /**
     * Display a specific page by slug.
     */
    public function show(string $slug): View
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->select('title', 'slug', 'content')
            ->firstOrFail();

        return view('pages.page', compact('page'));
    }

    /**
     * Return the web app manifest file.
     */
    public function webmanifest()
    {
        return response()
            ->view('pages.webmanifest')
            ->header('Content-Type', 'application/manifest+json');
    }

    /**
     * Return the robots.txt file.
     */
    public function robots()
    {
        return response()
            ->view('pages.robots')
            ->header('Content-Type', 'text/plain');
    }
}
