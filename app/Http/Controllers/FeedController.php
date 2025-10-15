<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Response;

final class FeedController extends Controller
{
    public function posts(): Response
    {
        $posts = Post::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->whereIn('post_type_id', [1, 14])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $posts->first();

        return response()
            ->view('feeds.posts', ['posts' => $posts, 'latest' => $latest])
            ->header('Content-Type', 'text/xml');
    }

    public function stream(): Response
    {
        $posts = Post::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $posts->first();

        return response()
            ->view('feeds.posts', ['posts' => $posts, 'latest' => $latest])
            ->header('Content-Type', 'text/xml');
    }

    public function photos(): Response
    {
        $photos = Photo::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latest = $photos->first();

        return response()
            ->view('feeds.photos', ['photos' => $photos, 'latest' => $latest])
            ->header('Content-Type', 'text/xml');
    }
}
