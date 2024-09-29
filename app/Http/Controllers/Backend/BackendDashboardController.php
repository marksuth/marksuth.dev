<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class BackendDashboardController extends Controller
{
    public function index(): View|Factory|Application
    {
        $posts = Post::whereNull('meta->distant_past')
            ->whereNull('meta->near_future')
            ->whereNotIn('post_type_id', [28])
            ->latest('created_at')
            ->take(10)
            ->get();

        $photos = Photo::latest('created_at')
            ->take(9)
            ->get();

        return view('backend.index', compact('posts', 'photos'));
    }

    public function webmanifest(): Response
    {
        return response()
            ->view('backend.webmanifest')
            ->header('Content-Type', 'application/manifest+json');
    }
}
