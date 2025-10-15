<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\PostType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

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
    public function index(): Factory|View|Application
    {
        $posts = $this->getResultsOrFail($this->getArticlesAndNotes(), true, 10);

        return $this->renderPaginatedView('posts.index', 'posts', $posts);
    }

    /**
     * Display a stream of activity posts.
     */
    public function stream(): View|Factory|Application
    {
        $posts = $this->getResultsOrFail($this->getActivityPosts(), true, 20);

        return $this->renderPaginatedView('posts.stream', 'posts', $posts);
    }

    /**
     * Display an individual post.
     */
    public function show(string $year, string $month, $slug): Factory|View|Application
    {
        $post = Post::query()
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds);

        $this->applyYearMonthSlugConstraints($post, $year, $month, $slug);
        $this->applyPublishedConstraints($post);

        $post = $post->firstOrFail();

        return $this->renderSingleItemView('posts.post', 'post', $post);
    }

    /**
     * Display a listing of posts from a specific year.
     */
    public function year(string $year): View|Response
    {
        $query = Post::query()
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds);

        $this->applyPublishedConstraints($query);
        $this->applyDateFilters($query, $year);
        $this->applyPublishedDateOrdering($query);

        $posts = $this->getResultsOrFail($query, true, 10);

        return $this->renderPaginatedView('posts.year', 'posts', $posts, ['year' => $year]);
    }

    /**
     * Display a listing of posts from a specific month.
     */
    public function month(int $year, int $month): Factory|View|Application
    {
        $query = Post::query()
            ->whereNotIn('post_type_id', $this->excludedPostTypeIds);

        $this->applyPublishedConstraints($query);
        $this->applyDateFilters($query, $year, $month);
        $this->applyPublishedDateOrdering($query);

        $posts = $this->getResultsOrFail($query, true, 10);

        return $this->renderPaginatedView('posts.month', 'posts', $posts, [
            'year' => $year,
            'month' => $month,
        ]);
    }

    /**
     * Display a listing of posts of a specific type.
     */
    public function type(string $type): Factory|View|Application
    {
        $type = $this->getPostTypeBySlug($type);
        $posts = $this->getResultsOrFail($this->getPostsByType($type), true, 10);

        return $this->renderPaginatedView('posts.type', 'posts', $posts, ['type' => $type]);
    }

    /**
     * Display a listing of posts types.
     */
    public function types(): Factory|View|Application
    {
        $types = PostType::query()->whereNotIn('id', $this->excludedPostTypeIds)->get();

        // Get Post count for each type
        foreach ($types as $type) {
            $query = Post::query()->where('post_type_id', $type->id);
            $this->applyPublishedConstraints($query);
            $type->count = $query->count();
        }

        return $this->renderView('posts.types', ['types' => $types]);
    }

    /**
     * Display posts from a specific collection.
     */
    public function post_collection($collection): Factory|View|Application
    {
        $collection = PostCollection::query()->where('slug', $collection)->firstOrFail();

        $query = Post::query()->where('collection_id', $collection->id);
        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);

        $posts = $this->getResultsOrFail($query, true, 10);

        return $this->renderPaginatedView('collections.collection', 'posts', $posts, [
            'collection' => $collection,
        ]);
    }

    /**
     * Display a listing of posts from the distant past.
     */
    public function distant_past_type($type): Factory|View|Application
    {
        $type = $this->getPostTypeBySlug($type);

        $query = Post::query()->where('post_type_id', $type->id)
            ->whereNowOrPast('published_at')
            ->where('meta->distant_past', 1);

        $this->applyPublishedDateOrdering($query);

        $posts = $this->getResultsOrFail($query, true, 30);

        return $this->renderPaginatedView('posts.distantpast.type', 'posts', $posts, [
            'type' => $type,
        ]);
    }

    /**
     * Display a listing of posts from the near future.
     */
    public function near_future_type($type): Factory|View|Application
    {
        $type = PostType::query()->where('name', $type)->firstOrFail();

        $query = Post::query()->where('post_type_id', $type->id)
            ->where('meta->published', '1')
            ->whereNowOrPast('published_at')
            ->whereNull('meta->distant_past')
            ->where('meta->near_future', '1');

        $this->applyPublishedDateOrdering($query);

        $posts = $this->getResultsOrFail($query, true, 10);

        return $this->renderPaginatedView('posts.nearfuture.type', 'posts', $posts, [
            'type' => $type,
        ]);
    }

    /**
     * Get a post type by slug.
     */
    private function getPostTypeBySlug(string $slug): PostType
    {
        return PostType::query()->where('slug', $slug)
            ->whereNotIn('id', $this->excludedPostTypeIds)
            ->firstOrFail();
    }

    /**
     * Get posts by type.
     */
    private function getPostsByType(PostType $type)
    {
        $query = Post::query()->where('post_type_id', $type->id);
        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);

        return $query;
    }

    /**
     * Get articles and notes posts.
     */
    private function getArticlesAndNotes()
    {
        $query = Post::query()->whereIn('post_type_id', [1, 14])
            ->select($this->standardPostFields);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);

        return $query;
    }

    /**
     * Get activity posts.
     */
    private function getActivityPosts()
    {
        $query = Post::query()->whereNotIn('post_type_id', [1, 14, 28])
            ->select($this->standardPostFields);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);

        return $query;
    }
}
