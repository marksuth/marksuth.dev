<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

final class PageController extends Controller
{
    /**
     * Standard fields to select for post listings
     */
    private array $standardPostFields = ['id', 'title', 'slug', 'post_type_id', 'content', 'published_at'];

    /**
     * Standard fields to select for photo listings
     */
    private array $standardPhotoFields = ['id', 'title', 'slug', 'meta', 'published_at'];

    /**
     * Display the home page with various content sections.
     */
    public function home(): View|Factory|Application
    {
        $data = [
            'posts' => $this->getRecentArticlesAndNotes(),
            'activities' => $this->getRecentActivities(),
            'watched' => $this->getRecentWatchedContent(),
            'photos' => $this->getRecentPhotos(),
            'latest_photo' => $this->getLatestPhoto(),
        ];

        return $this->renderView('pages.home', $data);
    }

    /**
     * Display a specific page by slug.
     */
    public function show($slug): View|Factory|Application
    {
        $page = Page::query()->where('slug', $slug)
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
    private function getRecentArticlesAndNotes(): object
    {
        $query = Post::query()->whereIn('post_type_id', [1, 14])
            ->select($this->standardPostFields);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take(3);

        // Eager load post type relationship
        return $this->getResultsOrFail($query, false, 10, ['postType'], true, 30);
    }

    /**
     * Get recent activities.
     */
    private function getRecentActivities(): object
    {
        $query = Post::query()->whereNotIn('post_type_id', [1, 14, 28])
            ->select(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take(9);

        // Eager load post type relationship
        return $this->getResultsOrFail($query, false, 10, ['postType'], true, 30);
    }

    /**
     * Get recent watched content.
     */
    private function getRecentWatchedContent(): object
    {
        $query = Post::query()->where('post_type_id', '23')
            ->where('collection_id', '3');

        $this->applyPublishedConstraints($query);
        $this->applyPublishedDateOrdering($query);
        $query->take(3);

        // Eager load post type and collection relationships
        return $this->getResultsOrFail($query, false, 10, ['postType', 'postCollection'], true, 30);
    }

    /**
     * Get recent photos.
     */
    private function getRecentPhotos(): object
    {
        $query = Photo::query()->where('meta->published', '1')
            ->select($this->standardPhotoFields)
            ->latest('published_at')
            ->take(6);

        // Cache the query results
        return $this->getResultsOrFail($query, false, 10, [], true, 30);
    }

    /**
     * Get the latest photo from the last day.
     */
    private function getLatestPhoto()
    {
        $query = Photo::query()->where('meta->published', '1')
            ->where('published_at', '>=', now()->subDay())
            ->select($this->standardPhotoFields)
            ->latest('published_at');

        // Cache the query results for a shorter time (10 minutes) since it's time-sensitive
        // Note: We need to handle the case where there's no photo differently than getResultsOrFail
        $cacheKey = $this->generateCacheKey($query, false, 1);

        return Cache::remember($cacheKey, now()->addMinutes(10), fn () => $query->first());
    }
}
