<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View|Application
    {
        // Get Article and Note Posts
        $posts = Post::where('published_at', '<=', now())
            ->whereIn('post_type_id', [1, 14])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->select('id', 'title', 'slug', 'post_type_id', 'content', 'published_at')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function stream(): View|Factory|Application
    {
        $posts = Post::where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->select('id', 'title', 'slug', 'post_type_id', 'content', 'published_at')
            ->latest('published_at')
            ->paginate(20);

        return view('posts.stream', compact('posts'));
    }

    /**
     * Display an individual post.
     */
    public function show($year, $month, $slug): Factory|View|Application
    {
        $post = Post::where('published_at', 'like', $year.'-'.$month.'%')
            ->where('slug', $slug)
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->firstOrFail();

        return view('posts.post', compact('post'));
    }

    public function posts($type): Factory|View|Application
    {
        $type = PostType::where('slug', $type)->firstOrFail();

        $posts = Post::where('post_type_id', $type->id)
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->firstOrFail()
            ->paginate(10);

        return view('posts.type', compact('posts', 'type'));

    }

    /**
     * Display a listing of posts from a specific year.
     */
    public function year(string $year): View|Response
    {
        $posts = Post::whereYear('published_at', $year)
            ->where('meta->published', 1)
            ->where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->firstOrFail()
            ->paginate(10);

        return view('posts.year', compact('posts', 'year'));

    }

    /**
     * Display a listing of posts from a specific month.
     */
    public function month(int $year, int $month): Factory|View|Application
    {
        $posts = Post::whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->where('meta->published', 1)
            ->whereNotIn('post_type_id', [28])
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->firstOrFail()
            ->paginate(10);

        return view('posts.month', compact('posts', 'year', 'month'));
    }

    /**
     * Display a listing of posts of a specific type.
     */
    public function type(string $type): Factory|View|Application
    {
        $type = PostType::where('slug', $type)
            ->whereNotIn('id', [28])
            ->firstOrFail();

        $posts = Post::where('post_type_id', $type->id)
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.type', compact('posts', 'type'));
    }

    /**
     * Display a listing of posts types.
     */
    public function types(): Factory|View|Application
    {
        $types = PostType::whereNotIn('id', [28])->get();

        // Get Post count for each type
        foreach ($types as $type) {
            $type->count = Post::where('post_type_id', $type->id)
                ->where('meta->published', 1)
                ->where('published_at', '<=', now())
                ->whereNull('meta->distant_past')
                ->whereNull('meta->near_future')
                ->count();
        }

        return view('posts.types', compact('types'));
    }

    public function post_collection($collection): Factory|View|Application
    {
        $collection = PostCollection::where('slug', $collection)->firstOrFail();

        $posts = Post::where('collection_id', $collection->id)
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(10);

        return view('collections.collection', compact('posts', 'collection'));
    }

    /**
     * Display a listing of posts from the distant past.
     */
    public function distant_past_type($type): Factory|View|Application
    {
        $type = PostType::where('slug', $type)->firstOrFail();

        $posts = Post::where('post_type_id', $type->id)
            ->where('published_at', '<=', now())
            ->where('meta->distant_past', 1)
            ->latest('published_at')
            ->firstOrFail()
            ->paginate(30);

        return view('posts.distantpast.type', compact('posts', 'type'));

    }

    /**
     * Display a listing of posts from the distant past.
     */
    public function near_future_type($type): Factory|View|Application
    {
        $type = PostType::where('name', $type)->firstOrFail();

        // Display Posts from the Near Future
        $posts = Post::where('post_type_id', $type->id)
            ->where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->where('meta->near_future', '1')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.nearfuture.type', compact('posts', 'type'));
    }

    public function search(Request $request): View|Factory|\Illuminate\Foundation\Application
    {
        $posts = Post::search($request->input('query'))->where('published_at', '<=', now())->get();
        $photos = Photo::search($request->input('query'))->get();

        return view('search.search', compact('photos', 'posts'));
    }
}
