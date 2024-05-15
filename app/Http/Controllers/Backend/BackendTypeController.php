<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostType;

class BackendTypeController extends Controller
{
    public function index()
    {
        $types = PostType::all()->sortBy('title');

        return view('backend.types.index', compact('types'));
    }

    public function create()
    {
        return view('backend.types.type');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $type = new PostType;

        $type->name = request('name');
        $type->description = request('description');
        $type->slug = Str::slug($request->input('title'));

        $type->save();

        return redirect()->route('backend.types.index');
    }

    public function edit($id)
    {
        $type = PostType::findOrFail($id);

        return view('backend.types.type', compact('type'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $type = PostType::findOrFail($id);

        $type->name = request('name');
        $type->description = request('description');
        $type->slug = Str::slug($request->input('title'));

        $meta = [];
        $meta['published'] = request('published') ? 1 : 0;
        $meta['img_url'] = request('image')->store('public/photos');
        $meta['img_url'] = str_replace('public/', '', $meta['img_url']);

        $type->meta = $meta;

        $type->save();

        return redirect()->route('backend.types.index');
    }

    public function destroy($id)
    {
        $type = PostType::findOrFail($id);

        $type->delete();

        return redirect()->route('backend.types.index');
    }
}
