<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $search = $request->get('query');
        $posts = Post::search($request->input('query'))->paginate(10);
        $photos = Photo::search($request->input('query'))->get();

        return view('search.search', compact('posts', 'photos', 'search'));
    }
}
