<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class PhotoController extends Controller
{
    /**
     * Standard fields to select for photo listings
     */
    private array $standardPhotoFields = ['id', 'title', 'slug', 'meta', 'published_at'];

    /**
     * Display a listing of photos.
     */
    public function index(): Factory|View|Application
    {
        $photos = $this->getResultsOrFail($this->getPublishedPhotos());

        return $this->renderPaginatedView('photos.index', 'photos', $photos);
    }

    /**
     * Display a specific photo by year, month, and slug.
     */
    public function show(string $year, string $month, string $slug): Factory|View|Application
    {
        $query = Photo::query();
        $this->applyYearMonthSlugConstraints($query, $year, $month, $slug);

        // Generate a cache key for this specific photo query
        $cacheKey = 'photo_'.$year.'_'.$month.'_'.$slug;

        // Cache the result for 60 minutes
        $photo = Cache::remember($cacheKey, now()->addMinutes(60), fn () => $query->firstOrFail());

        return $this->renderSingleItemView('photos.photo', 'photo', $photo);
    }

    /**
     * Display photos from a specific year.
     */
    public function year($year): Factory|View|Application
    {
        $photos = $this->getResultsOrFail($this->getPhotosByDate($year));

        return $this->renderPaginatedView('photos.year', 'photos', $photos, ['year' => $year]);
    }

    /**
     * Display photos from a specific month.
     */
    public function month($year, $month): Factory|View|Application
    {
        $photos = $this->getResultsOrFail($this->getPhotosByDate($year, $month));

        return $this->renderPaginatedView('photos.month', 'photos', $photos, [
            'year' => $year,
            'month' => $month,
        ]);
    }

    /**
     * Get published photos query.
     */
    private function getPublishedPhotos()
    {
        $query = Photo::query()->where('meta->published', '1')
            ->select($this->standardPhotoFields);

        $this->applyPublishedDateOrdering($query);

        return $query;
    }

    /**
     * Get photos by date.
     */
    private function getPhotosByDate($year, $month = null)
    {
        $query = Photo::query()->where('meta->published', '1')
            ->select($this->standardPhotoFields)
            ->whereNowOrPast('published_at');

        $this->applyDateFilters($query, $year, $month);
        $this->applyPublishedDateOrdering($query);

        return $query;
    }
}
