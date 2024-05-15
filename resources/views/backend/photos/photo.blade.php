@extends('layouts.backend', [
    'title' => 'Photo Editor',
])
@section('content')
    <h1>{{ $photo->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
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
                    <div class="tile">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image"
                               accept="image/*" value="{{ $photo->meta['img_url'] ?? '' }}">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title"
                               value="{{ $photo->title ?? '' }}">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location"
                               value="{{ $photo->meta['location'] ?? '' }}">
                        <label for="content" class="h6">Description</label>
                        <textarea id="content" name="content"
                                  rows="5">{{ $photo->content ?? '' }}</textarea>
                        <label for="published_at">Publish at</label>
                        <input type="datetime-local" id="published_at"
                               name="published_at"
                               value="{{ isset($photo->published_at) ? $photo->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">
                        <input class="form-check-input" type="checkbox" id="published"
                               name="published"
                               value="1" {{ isset($photo->meta['published']) && $photo->meta['published'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">Published</label>
                        @if(isset($photo->id)  && $photo->meta['published'] == 1)
                            <button type="submit" class="btn">Update Photo</button>
                        @elseif(isset($photo->id) && $photo->meta['published'] != 1)
                            <button type="submit" class="btn">Update Draft</button>
                        @else
                            <button type="submit" class="btn">Save Photo</button>
                        @endif
                    </div>
                </form>
        @endsection
