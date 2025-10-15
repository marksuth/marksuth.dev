<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PostCollectionController extends Controller
{
    /**
     * Display a listing of posts collections.
     */
    public function index(): Factory|View|Application
    {
        $collections = PostCollection::all();

        return view('collections.index', ['collections' => $collections]);
    }

    /**
     * Display a listing of posts from a specific collections.
     */
    public function show(string $collection): Factory|View|Application
    {
        $collection = PostCollection::query()->where('slug', $collection)->firstOrFail();

        // Get posts from posts table that match the collection_id
        $posts = Post::query()->whereNowOrPast('published_at')
            ->where('collection_id', $collection->id)
            ->select('title', 'slug', 'meta', 'content', 'published_at')
            ->latest('published_at')
            ->get();

        return view('collections.collection', ['collection' => $collection, 'posts' => $posts]);
    }
}
