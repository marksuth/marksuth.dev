<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Contracts\View\View;

final class PostController extends Controller
{
    /**
     * Standard fields to select for post listings
     */
    private array $standardPostFields = ['id', 'title', 'slug', 'post_type_id', 'content', 'published_at'];

    /**
     * Post type IDs to exclude from standard queries
     */
    private array $excludedPostTypeIds = [28];

    /**
     * Display a listing of articles and notes.
     */
    public function index(): View
    {
        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->whereIn('post_type_id', [1, 14])
            ->published()
            ->current()
            ->latest('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display a stream of activity posts.
     */
    public function stream(): View
    {
        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->whereNotIn('post_type_id', [1, 14, 28])
            ->published()
            ->current()
            ->latest('published_at')
            ->paginate(20);

        return view('posts.stream', compact('posts'));
    }

    /**
     * Display an individual post.
     */
    public function show(string $year, string $month, string $slug): View
    {
        $post = Post::query()
            ->with(['postType', 'postCollection'])
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds)
            ->published()
            ->where('published_at', 'like', "{$year}-{$month}%")
            ->where('slug', $slug)
            ->firstOrFail();

        return view('posts.post', compact('post'));
    }

    /**
     * Display a listing of posts from a specific year.
     */
    public function year(int $year): View
    {
        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds)
            ->published()
            ->current()
            ->whereYear('published_at', $year)
            ->latest('published_at')
            ->paginate(10);

        if ($posts->isEmpty()) {
            abort(404);
        }

        return view('posts.year', compact('posts', 'year'));
    }

    /**
     * Display a listing of posts from a specific month.
     */
    public function month(int $year, int $month): View
    {
        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds)
            ->published()
            ->current()
            ->whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->latest('published_at')
            ->paginate(10);

        if ($posts->isEmpty()) {
            abort(404);
        }

        return view('posts.month', compact('posts', 'year', 'month'));
    }

    /**
     * Display a listing of posts of a specific type.
     */
    public function type(string $type): View
    {
        $type = PostType::query()
            ->where('slug', $type)
            ->whereNotIn('id', $this->excludedPostTypeIds)
            ->firstOrFail();

        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->where('post_type_id', $type->id)
            ->published()
            ->current()
            ->latest('published_at')
            ->paginate(10);

        return view('posts.type', compact('posts', 'type'));
    }

    /**
     * Display a listing of posts types.
     */
    public function types(): View
    {
        $types = PostType::query()
            ->whereNotIn('id', $this->excludedPostTypeIds)
            ->withCount(['postsMany' => function ($query) {
                $query->published()->current();
            }])
            ->get();

        return view('posts.types', compact('types'));
    }

    /**
     * Display posts from a specific collection.
     */
    public function post_collection(string $collection): View
    {
        $collection = PostCollection::query()->where('slug', $collection)->firstOrFail();

        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with(['postType', 'postCollection'])
            ->where('collection_id', $collection->id)
            ->published()
            ->current()
            ->latest('published_at')
            ->paginate(10);

        return view('collections.collection', compact('posts', 'collection'));
    }

    /**
     * Display a listing of posts from the distant past.
     */
    public function distant_past_type(string $type): View
    {
        $type = PostType::query()
            ->where('slug', $type)
            ->whereNotIn('id', $this->excludedPostTypeIds)
            ->firstOrFail();

        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->where('post_type_id', $type->id)
            ->published()
            ->where('meta->distant_past', '1')
            ->latest('published_at')
            ->paginate(30);

        return view('posts.distantpast.type', compact('posts', 'type'));
    }

    /**
     * Display a listing of posts from the near future.
     */
    public function near_future_type(string $type): View
    {
        $type = PostType::query()->where('name', $type)->firstOrFail();

        $posts = Post::query()
            ->select($this->standardPostFields)
            ->with('postType')
            ->where('post_type_id', $type->id)
            ->published()
            ->where('meta->near_future', '1')
            ->latest('published_at')
            ->paginate(10);

        return view('posts.nearfuture.type', compact('posts', 'type'));
    }
}
