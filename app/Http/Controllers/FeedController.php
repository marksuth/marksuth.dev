<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;

class FeedController extends Controller
{
    public function posts()
    {
        $posts = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereIn('post_type_id', [1, 14])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $posts->first();

        return response()
            ->view('feeds.posts', compact('posts', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function stream()
    {
        $posts = Post::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->take(10)
            ->get();


        $latest = $posts->first();

        return response()
            ->view('feeds.posts', compact('posts', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function photos()
    {
        $photos = Photo::where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $photos->first();

        return response()
            ->view('feeds.photos', compact('photos', 'latest'))
            ->header('Content-Type', 'text/xml');
    }
}
