<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('query');
        $posts = Post::search($request->input('query'))->paginate(10);
        $photos = Photo::search($request->input('query'))->get();

        return view('search.search', compact('posts', 'photos', 'search'));
    }

    public function post_search(Request $request)
    {
        $search = $request->get('query');
        $posts = Post::search($request->input('query'))->paginate(10);

        return view('search.search', compact('posts', 'search'));
    }

    public function photo_search(Request $request)
    {
        $search = $request->get('query');
        $photos = Photo::search($request->input('query'))->get();

        return view('search.search', compact('photos', 'search'));
    }
}
