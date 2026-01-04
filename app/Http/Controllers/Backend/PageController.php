<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index(): View
    {
        return view('backend.pages.index', [
            'pages' => Page::latest()->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        return view('backend.pages.manage', [
            'title' => 'Create Page',
        ]);
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(StorePageRequest $request): RedirectResponse
    {
        Page::create($request->validated());

        return redirect()->route('backend.pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page): View
    {
        return view('backend.pages.manage', [
            'title' => 'Edit Page',
            'page' => $page,
        ]);
    }

    /**
     * Update the specified page in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $page->update($request->validated());

        return redirect()->route('backend.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('backend.pages.index')->with('success', 'Page deleted successfully.');
    }
}
