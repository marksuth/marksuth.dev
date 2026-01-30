<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class PhotoController extends Controller
{
    /**
     * Display a listing of the photos.
     */
    public function index(): View
    {
        return view('backend.photos.index', [
            'photos' => Photo::latest()->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new photo.
     */
    public function create(): View
    {
        return view('backend.photos.manage', [
            'title' => 'Add Photo',
        ]);
    }

    /**
     * Store a newly created photo in storage.
     */
    public function store(StorePhotoRequest $request): RedirectResponse
    {
        Photo::create($request->validated());

        return redirect()->route('backend.photos.index')->with('success', 'Photo added successfully.');
    }

    /**
     * Display the specified photo.
     */
    public function show(Photo $photo): View
    {
        return view('backend.photos.show', [
            'photo' => $photo,
        ]);
    }

    /**
     * Show the form for editing the specified photo.
     */
    public function edit(Photo $photo): View
    {
        return view('backend.photos.manage', [
            'title' => 'Edit Photo',
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified photo in storage.
     */
    public function update(UpdatePhotoRequest $request, Photo $photo): RedirectResponse
    {
        $photo->update($request->validated());

        return redirect()->route('backend.photos.index')->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified photo from storage.
     */
    public function destroy(Photo $photo): RedirectResponse
    {
        $photo->delete();

        return redirect()->route('backend.photos.index')->with('success', 'Photo deleted successfully.');
    }
}
