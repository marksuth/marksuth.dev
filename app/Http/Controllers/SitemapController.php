<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\PostType;

class SitemapController extends Controller
{
    public function index()
    {
        return response()
            ->view('sitemaps.index')
            ->header('Content-Type', 'text/xml');
    }

    public function posts()
    {

        $latest = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->orderBy('published_at', 'desc')
            ->first();

        $posts = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->orderBy('published_at', 'desc')->get();

        $types = PostType::whereNotIn('id', [28])->get();

        foreach ($types as $type) {
            $type->count = Post::where('post_type_id', $type->id)
                ->where('meta->published', 1)
                ->whereNotIn('post_type_id', [28])
                ->where('published_at', '<=', now())
                ->whereNull('meta->distant_past')
                ->whereNull('meta->near_future')
                ->count();
        }

        return response()
            ->view('sitemaps.posts', compact('posts', 'types', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function photos()
    {
        $photos = Photo::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')->get();

        return response()
            ->view('sitemaps.photos', compact('photos'))
            ->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        $pages = Page::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->orderBy('updated_at', 'desc')->get();

        return response()
            ->view('sitemaps.pages', compact('pages'))
            ->header('Content-Type', 'text/xml');
    }
}
