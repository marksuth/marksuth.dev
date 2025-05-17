<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Standard fields to select for post listings
     */
    protected $standardPostFields = ['id', 'title', 'slug', 'post_type_id', 'content', 'published_at'];

    /**
     * Standard fields to select for photo listings
     */
    protected $standardPhotoFields = ['id', 'title', 'slug', 'meta', 'published_at'];

    /**
     * Post type IDs to exclude from standard queries
     */
    protected $excludedPostTypeIds = [28];

    /**
     * Display the home page with various content sections.
     */
    public function home(): View|Factory|Application
    {
        $data = [
            'posts' => $this->getRecentArticlesAndNotes(3),
            'activities' => $this->getRecentActivities(9),
            'watched' => $this->getRecentWatchedContent(3),
            'photos' => $this->getRecentPhotos(6),
            'latest_photo' => $this->getLatestPhoto(),
        ];

        return $this->renderView('pages.home', $data);
    }

    /**
     * Display a specific page by slug.
     */
    public function show($slug): View|Factory|Application
    {
        $page = Page::where('slug', $slug)
            ->select('title', 'slug', 'content')
            ->firstOrFail();

        return $this->renderSingleItemView('pages.page', 'page', $page);
    }

    /**
     * Return the web app manifest file.
     */
    public function webmanifest(): Response
    {
        return $this->renderSpecialResponse('pages.webmanifest', 'application/manifest+json');
    }

    /**
     * Return the robots.txt file.
     */
    public function robots(): Response
    {
        return $this->renderSpecialResponse('pages.robots', 'text/plain');
    }

    /**
     * Get recent articles and notes.
     */
    protected function getRecentArticlesAndNotes(int $limit = 3): object
    {
        $query = Post::whereIn('post_type_id', [1, 14])
            ->select($this->standardPostFields);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take($limit);

        // Eager load post type relationship
        return $this->getResultsOrFail($query, false, 10, ['postType'], true, 30);
    }

    /**
     * Get recent activities.
     */
    protected function getRecentActivities(int $limit = 9): object
    {
        $query = Post::whereNotIn('post_type_id', [1, 14, 28])
            ->select(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take($limit);

        // Eager load post type relationship
        return $this->getResultsOrFail($query, false, 10, ['postType'], true, 30);
    }

    /**
     * Get recent watched content.
     */
    protected function getRecentWatchedContent(int $limit = 3): object
    {
        $query = Post::where('post_type_id', '23')
            ->where('collection_id', '3');

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take($limit);

        // Eager load post type and collection relationships
        return $this->getResultsOrFail($query, false, 10, ['postType', 'postCollection'], true, 30);
    }

    /**
     * Get recent photos.
     */
    protected function getRecentPhotos(int $limit = 6): object
    {
        $query = Photo::where('meta->published', '1')
            ->select($this->standardPhotoFields)
            ->latest('published_at')
            ->take($limit);

        // Cache the query results
        return $this->getResultsOrFail($query, false, 10, [], true, 30);
    }

    /**
     * Get the latest photo from the last day.
     */
    protected function getLatestPhoto()
    {
        $query = Photo::where('meta->published', '1')
            ->where('published_at', '>=', now()->subDay())
            ->select($this->standardPhotoFields)
            ->latest('published_at');

        // Cache the query results for a shorter time (10 minutes) since it's time-sensitive
        // Note: We need to handle the case where there's no photo differently than getResultsOrFail
        $cacheKey = $this->generateCacheKey($query, false, 1);

        return \Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query) {
            return $query->first();
        });
    }
}
