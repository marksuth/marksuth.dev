<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostCollection;
use Illuminate\Support\Str;

class BackendCollectionController extends Controller
{
    public function index()
    {
        $collections = PostCollection::all()->sortBy('name');

        return view('backend.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('backend.collections.collection');
    }

    public function store()
    {
        $collection = new PostCollection();

        $collection->name = request('name');
        $collection->slug = Str::slug(request('name'));
        $collection->description = request('description');
        $meta = [];
        $meta['published'] = request('published') ? 1 : 0;

        $collection->meta = $meta;

        $collection->save();

        return redirect()->route('backend.collections');
    }

    public function edit($id)
    {
        $collection = PostCollection::findOrFail($id);

        return view('backend.collections.collection', compact('collection'));
    }

    public function update($id)
    {

        $collection = PostCollection::findOrFail($id);

        $collection->name = request('name');
        $collection->slug = Str::slug(request('name'));
        $collection->description = request('description');

        $meta = [];
        $meta['published'] = request('published');

        $collection->meta = $meta;

        $collection->save();

        return redirect()->route('backend.collections');
    }

    public function destroy($id)
    {
        $collection = PostCollection::findOrFail($id);

        $collection->delete();

        return redirect()->route('backend.collections');
    }
}
