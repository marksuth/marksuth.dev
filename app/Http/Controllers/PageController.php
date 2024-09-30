<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function home(): View|Factory|Application
    {
        $posts = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereIn('post_type_id', [1, 14])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->select('id', 'title', 'slug', 'post_type_id', 'content', 'published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        $activities = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->select('id', 'title', 'slug', 'post_type_id', 'published_at')
            ->latest('published_at')
            ->take(9)
            ->get();

        $photos = Photo::where('meta->published', '1')
            ->latest('published_at')
            ->select('id', 'title', 'slug', 'meta', 'published_at')
            ->take(9)
            ->get();

        $latest_photo = Photo::where('meta->published', '1')
            ->latest('published_at')
            ->select('id', 'title', 'slug', 'meta', 'published_at')
            ->first();

        if ($latest_photo->published_at->diffInHours(now()) > 24) {
            $latest_photo = null;
        }

        return view('pages.home', compact('posts', 'activities', 'photos', 'latest_photo'));
    }

    public function show($slug): View|Factory|Application
    {
        $page = Page::where('slug', $slug)
            ->select('title', 'slug', 'content')
            ->firstOrFail();

        return view('pages.page', compact('page'));
    }

    public function webmanifest(): Response
    {
        return response()
            ->view('pages.webmanifest')
            ->header('Content-Type', 'application/manifest+json');
    }

    public function robots(): Response
    {
        return response()
            ->view('pages.robots')
            ->header('Content-Type', 'text/plain');
    }
}
