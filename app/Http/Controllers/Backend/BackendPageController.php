<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class BackendPageController extends Controller
{
    public function index(): View|Factory|Application
    {
        $pages = Page::latest()->orderBy('title')->paginate(20);

        return view('backend.pages.index', compact('pages'));
    }

    public function create(): View|Factory|Application
    {
        return view('backend.pages.page');
    }

    public function store(): Application|Redirector|RedirectResponse
    {

        $page = new Page;

        $page->title = request('title');
        $page->slug = Str::slug(request('title'));
        $page->content = request('content');

        $meta = [];
        $meta['published'] = request('published');

        $page->meta = $meta;

        $page->save();

        return redirect('/backend/pages');
    }

    public function edit($id): View|Factory|Application
    {
        $page = Page::find($id);

        return view('backend.pages.page', compact('page'));
    }

    public function update($id): Application|Redirector|RedirectResponse
    {

        $page = Page::find($id);

        $page->title = request('title');
        $page->slug = Str::slug(request('title'));
        $page->content = request('content');

        $meta = [];
        $meta['published'] = request('published');

        $page->meta = $meta;

        $page->save();

        return redirect('/backend/pages');
    }

    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $page = Page::find($id);

        $page->delete();

        return redirect('/backend/pages');
    }
}
