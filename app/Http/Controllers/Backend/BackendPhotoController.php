<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Exceptions\CouldNotLoadImage;
use Spatie\Image\Image;

class BackendPhotoController extends Controller
{
    public function index(): View|Factory|Application
    {
        $photos = Photo::latest('created_at')->get();

        //        dd($photos->first()->meta['img_url']);

        return view('backend.photos.index', compact('photos'));
    }

    public function create(): View|Factory|Application
    {
        return view('backend.photos.photo');
    }

    /**
     * @throws CouldNotLoadImage
     */
    public function store(): Application|Redirector|RedirectResponse
    {

        $photo = new Photo;

        $photo->title = request('title');
        $photo->slug = Str::slug(request('title'));
        $photo->content = request('content');
        $photo->published_at = request('published_at');

        $image = request('image')->store('public/photos');
        Image::load(storage_path('app/'.$image))
            ->quality(85)
            ->fit(Fit::Max, 2000, 2000)
            ->save();

        $thumb = request('image')->store('public/thumbs');
        Image::load(storage_path('app/'.$thumb))
            ->fit(Fit::Crop, 500, 500)
            ->quality(85)
            ->save();

        $meta = [];
        $meta['img_url'] = str_replace('storage/photos/', '', Storage::url($image));
        $meta['location'] = request('location');
        $meta['instagram_url'] = request('instagram_url');
        $meta['published'] = request('published');

        $photo->meta = $meta;

        $photo->save();

        return redirect('/backend/photos');
    }

    public function show($id): View|Factory|Application
    {
        $photo = Photo::find($id);

        return view('backend.photos.photo', compact('photo'));
    }

    public function update($id): Application|Redirector|RedirectResponse
    {

        $photo = Photo::find($id);

        $photo->title = request('title');
        $photo->slug = Str::slug(request('title'));
        $photo->content = request('content');
        $photo->published_at = request('published_at');

        $meta[] = $photo->meta;
        $meta['location'] = request('location');
        $meta['instagram_url'] = request('instagram_url');
        $meta['published'] = request('published');

        $photo->meta = $meta;

        $photo->save();

        return redirect('/backend/photos');
    }

    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $photo = Photo::find($id);

        $photo->delete();

        return redirect('/backend/photos');
    }
}
