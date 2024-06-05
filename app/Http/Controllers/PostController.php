<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        //Get Article and Note Posts
        $posts = Post::where('published_at', '<=', now())
            ->whereIn('post_type_id', [1, 14])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function stream()
    {
        $posts = Post::where('published_at', '<=', now())
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(20);

        return view('posts.stream', compact('posts'));
    }

    /**
     * Display an individual post.
     *
     * @return Application|Factory|View
     */
    public function show($year, $month, $slug)
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

    public function posts($type)
    {
        $type = PostType::where('slug', $type)->firstOrFail();

        $posts = Post::where('post_type_id', $type->id)
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(10);

        if ($posts->count() == 0) {
            return abort(404);
        } else {
            return view('posts.type', compact('posts', 'type'));
        }
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
            ->paginate(10);

        if ($posts->count() == 0) {
            return abort(404);
        } else {
            return view('posts.year', compact('posts', 'year'));
        }
    }

    /**
     * Display a listing of posts from a specific month.
     */
    public function month(int $year, int $month): Application|Factory|View
    {
        $posts = Post::whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->where('meta->published', 1)
            ->whereNotIn('post_type_id', [28])
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->latest('published_at')
            ->paginate(10);

        if ($posts->count() == 0) {
            return abort(404);
        } else {
            return view('posts.month', compact('posts', 'year', 'month'));
        }
    }

    /**
     * Display a listing of posts of a specific type.
     *
     * @param  string  $type
     * @return Application|Factory|View
     */
    public function type($type)
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
     *
     * @return Application|Factory|View
     */
    public function types()
    {
        $types = PostType::whereNotIn('id', [28])->get();

        //Get Post count for each type
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

    public function post_collection($collection)
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
     *
     * @return Application|Factory|View
     */
    public function distant_past_type($type)
    {
        $type = PostType::where('slug', $type)->firstOrFail();

        $posts = Post::where('post_type_id', $type->id)
            ->where('published_at', '<=', now())
            ->where('meta->distant_past', 1)
            ->latest('published_at')
            ->paginate(30);

        if ($posts->count() == 0) {
            return abort(404);
        } else {
            return view('posts.distantpast.type', compact('posts', 'type'));
        }
    }

    /**
     * Display a listing of posts from the distant past.
     *
     * @return Application|Factory|View
     */
    public function near_future_type($type)
    {
        $type = PostType::where('name', $type)->firstOrFail();

        //Display Posts from the Near Future
        $posts = Post::where('post_type_id', $type->id)
            ->where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->whereNull('meta->distant_past')
            ->where('meta->near_future', '1')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.nearfuture.type', compact('posts', 'type'));
    }

    public function search(Request $request)
    {
        $posts = Post::search($request->input('query'))->paginate(20);

        return view('search.search', compact('posts'));
    }
}
