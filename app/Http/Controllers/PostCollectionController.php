<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Contracts\View\View;

final class PostCollectionController extends Controller
{
    /**
     * Display a listing of posts collections.
     */
    public function index(): View
    {
        $collections = PostCollection::all();

        return view('collections.index', compact('collections'));
    }

    /**
     * Display a listing of posts from a specific collections.
     */
    public function show(string $collection): View
    {
        $collection = PostCollection::query()->where('slug', $collection)->firstOrFail();

        // Get posts from posts table that match the collection_id
        $posts = Post::query()
            ->published()
            ->where('collection_id', $collection->id)
            ->select('title', 'slug', 'meta', 'content', 'published_at')
            ->latest('published_at')
            ->get();

        return view('collections.collection', compact('collection', 'posts'));
    }
}
