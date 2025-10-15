<?php

declare(strict_types=1);

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

        $latest = Post::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->first();

        $posts = Post::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')->get();

        $types = PostType::query()->whereNotIn('id', [28])->get();

        foreach ($types as $type) {
            $type->count = Post::query()->where('post_type_id', $type->id)
                ->where('meta->published', 1)
                ->whereNotIn('post_type_id', [28])
                ->whereNowOrPast('published_at')
                ->whereNull('meta->distant_past')
                ->whereNull('meta->near_future')
                ->count();
        }

        return response()
            ->view('sitemaps.posts', ['posts' => $posts, 'types' => $types, 'latest' => $latest])
            ->header('Content-Type', 'text/xml');
    }

    public function photos(): Response
    {
        $photos = Photo::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->latest('published_at')->get();

        return response()
            ->view('sitemaps.photos', ['photos' => $photos])
            ->header('Content-Type', 'text/xml');
    }

    public function pages(): Response
    {
        $pages = Page::query()->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->latest('updated_at')->get();

        return response()
            ->view('sitemaps.pages', ['pages' => $pages])
            ->header('Content-Type', 'text/xml');
    }
}
