@extends('layouts.backend', [
    'title' => 'Photo Editor',
])
@section('content')
    <h1 class="py-3">{{ $photo->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-error my-0">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($photo->id))
        @if($photo->meta['published'])
            <p><a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}"
                  target="blank" class="btn btn-sm btn-link">View Photo ></a></p>
        @endif
        <form action="{{ route('backend.photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.photos.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="card bg-white shadow-sm p-3 rounded mb-4">
                        <div class="row">
                            @if (isset($photo->meta['img_url']))
                                <div class="col-md-6">
                                    <img src="/storage/photos/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}"
                                         class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    @else
                                        <div class="col-12">
                                            @endif
                                            <div class="mb-3">
                                                <label for="image" class="h6">Image</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                       accept="image/*" value="{{ $photo->meta['img_url'] ?? '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="title" class="h6">Title</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                       value="{{ $photo->title ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="location" class="h6">Location</label>
                                                <input type="text" class="form-control" id="location" name="location"
                                                       value="{{ $photo->meta['location'] ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="content" class="h6">Description</label>
                                                <textarea class="form-control" id="content" name="content"
                                                          rows="5">{{ $photo->content ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="published_at" class="h6">Publish at</label>
                                                <input type="datetime-local" class="form-control" id="published_at"
                                                       name="published_at"
                                                       value="{{ isset($photo->published_at) ? $photo->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="published"
                                                       name="published"
                                                       value="1" {{ isset($photo->meta['published']) && $photo->meta['published'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="published">Published</label>
                                            </div>
                                            <div class="mb-3 text-end">

                                                @if(isset($photo->id)  && $photo->meta['published'] == 1)
                                                    <button type="submit" class="btn btn-primary">Update Photo</button>
                                                @elseif(isset($photo->id) && $photo->meta['published'] != 1)
                                                    <button type="submit" class="btn btn-primary">Update Draft</button>
                                                @else
                                                    <button type="submit" class="btn btn-primary">Save Photo</button>
                                                @endif
                                            </div>
                                        </div>
                                </div>

                        </div>
                    </div>
                </form>
        @endsection
