<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Response;

final class FeedController extends Controller
{
    public function posts(): Response
    {
        $posts = Post::query()
            ->published()
            ->current()
            ->whereIn('post_type_id', [1, 14])
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $posts->first();

        return response()
            ->view('feeds.posts', compact('posts', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function stream(): Response
    {
        $posts = Post::query()
            ->published()
            ->current()
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $posts->first();

        return response()
            ->view('feeds.posts', compact('posts', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function photos(): Response
    {
        $photos = Photo::query()
            ->published()
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $photos->first();

        return response()
            ->view('feeds.photos', compact('photos', 'latest'))
            ->header('Content-Type', 'text/xml');
    }
}
