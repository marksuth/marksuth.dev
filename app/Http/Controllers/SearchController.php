<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('query');
        $posts = Post::search($search)->paginate(10);
        $photos = Photo::search($search)->get();

        return view('search.search', compact('posts', 'photos', 'search'));
    }
}
