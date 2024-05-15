<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PostCollectionController extends Controller
{
    /**
     * Display a listing of posts collections.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $collections = PostCollection::all();

        return view('collections.index', compact('collections'));
    }

    /**
     * Display a listing of posts from a specific collections.
     *
     * @param  string  $collection
     * @return Application|Factory|View
     */
    public function show($collection)
    {
        $collection = PostCollection::where('slug', $collection)->firstOrFail();

        // Get posts from posts table that match the collection_id
        $posts = Post::where('published_at', '<=', now())
            ->where('collection_id', $collection->id)
            ->latest('published_at')
            ->get();

        return view('collections.collection', compact('collection', 'posts'));
    }
}
