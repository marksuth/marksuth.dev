<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $photos = Photo::where('meta->published', '1')
            ->latest('published_at')
            ->get();

        return view('photos.index', compact('photos'));
    }

    public function show($year, $month, $slug)
    {
        $photo = Photo::where('published_at', 'like', $year.'-'.$month.'%')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('photos.photo', compact('photo'));
    }

    public function year($year)
    {
        $photos = Photo::whereYear('published_at', $year)
            ->where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->get();

        if ($photos->count() == 0) {
            return abort(404);
        } else {
            return view('photos.year', compact('photos', 'year'));
        }
    }

    public function month($year, $month)
    {
        $photos = Photo::whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->where('meta->published', '1')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->get();

        if ($photos->count() == 0) {
            return abort(404);
        } else {
            return view('photos.month', compact('photos', 'year', 'month'));
        }
    }
}
