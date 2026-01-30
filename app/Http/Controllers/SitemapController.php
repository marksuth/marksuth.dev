<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Response;

final class SitemapController extends Controller
{
    public function index(): Response
    {
        return response()
            ->view('sitemaps.index')
            ->header('Content-Type', 'text/xml');
    }

    public function posts(): Response
    {
        $postsQuery = Post::query()
            ->published()
            ->whereNotIn('post_type_id', [28])
            ->current()
            ->latest('published_at');

        $latest = (clone $postsQuery)->first();
        $posts = $postsQuery->get();

        $types = PostType::query()
            ->whereNotIn('id', [28])
            ->withCount(['postsMany' => function ($query) {
                $query->published()->whereNotIn('post_type_id', [28])->current();
            }])
            ->get();

        return response()
            ->view('sitemaps.posts', compact('posts', 'types', 'latest'))
            ->header('Content-Type', 'text/xml');
    }

    public function photos(): Response
    {
        $photos = Photo::query()
            ->published()
            ->latest('published_at')
            ->get();

        return response()
            ->view('sitemaps.photos', compact('photos'))
            ->header('Content-Type', 'text/xml');
    }

    public function pages(): Response
    {
        $pages = Page::query()
            ->published()
            ->latest('updated_at')
            ->get();

        return response()
            ->view('sitemaps.pages', compact('pages'))
            ->header('Content-Type', 'text/xml');
    }
}
