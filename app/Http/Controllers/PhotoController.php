<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class PhotoController extends Controller
{
    /**
     * Display a listing of photos.
     */
    public function index(): View
    {
        $photos = Photo::query()
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view('photos.index', compact('photos'));
    }

    /**
     * Display a specific photo by year, month, and slug.
     */
    public function show(string $year, string $month, string $slug): View
    {
        $cacheKey = "photo_{$year}_{$month}_{$slug}";

        $photo = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($year, $month, $slug) {
            return Photo::query()
                ->where('published_at', 'like', "{$year}-{$month}%")
                ->where('slug', $slug)
                ->firstOrFail();
        });

        return view('photos.photo', compact('photo'));
    }

    /**
     * Display photos from a specific year.
     */
    public function year(int $year): View
    {
        $photos = Photo::query()
            ->published()
            ->whereYear('published_at', $year)
            ->latest('published_at')
            ->paginate(10);

        if ($photos->isEmpty()) {
            abort(404);
        }

        return view('photos.year', compact('photos', 'year'));
    }

    /**
     * Display photos from a specific month.
     */
    public function month(int $year, int $month): View
    {
        $photos = Photo::query()
            ->published()
            ->whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->latest('published_at')
            ->paginate(10);

        if ($photos->isEmpty()) {
            abort(404);
        }

        return view('photos.month', compact('photos', 'year', 'month'));
    }
}
