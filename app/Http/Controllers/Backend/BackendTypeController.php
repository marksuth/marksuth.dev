<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BackendTypeController extends Controller
{
    public function index(): View|Factory|Application
    {
        $types = PostType::all()->sortBy('title');

        return view('backend.types.index', compact('types'));
    }

    public function create(): View|Factory|Application
    {
        return view('backend.types.type');
    }

    /**
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        Validator::make(request()->all(), [
            'name' => 'required',
        ])->validate();

        $type = new PostType;

        $type->name = request('name');
        $type->description = request('description');
        $type->slug = Str::slug(request('title'));

        $type->save();

        return redirect()->route('backend.types.index');
    }

    public function edit($id): View|Factory|Application
    {
        $type = PostType::findOrFail($id);

        return view('backend.types.type', compact('type'));
    }

    /**
     * @throws ValidationException
     */
    public function update($id): RedirectResponse
    {
        Validator::make(request()->all(), [
            'name' => 'required',
        ])->validate();

        $type = PostType::findOrFail($id);

        $type->name = request('name');
        $type->description = request('description');
        $type->slug = Str::slug(request('title'));

        $meta[] = $type->meta;
        $meta['published'] = request('published') ? 1 : 0;

        $type->meta = $meta;

        $type->save();

        return redirect()->route('backend.types.index');
    }

    public function destroy($id): RedirectResponse
    {
        $type = PostType::findOrFail($id);

        $type->delete();

        return redirect()->route('backend.types.index');
    }
}
