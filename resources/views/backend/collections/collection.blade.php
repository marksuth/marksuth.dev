@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1>{{ $collection->title ?? 'New Collection' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($collection->id))
        <p><a href="/types/{{ $collection->slug }}" target="blank" class="btn btn-sm btn-link">View Collection ></a></p>
        <form action="{{ route('backend.collections.update', $collection->id) }}" method="POST"
              enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.collections.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="editor-split">
                        <div class="tile">
                            <label for="name">Collection Name</label>
                            <input type="text" id="name" name="name" value="{{ $collection->name ?? '' }}">
                            <label for="content">Description</label>
                            <textarea id="content" name="content"
                                      rows="5">{{ $collection->description ?? '' }}</textarea>
                            <label for="image">Collection cover</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                   value="{{ $post->meta['img_url'] ?? '' }}">
                            @if (isset($collection->meta['img_url']))
                                <img src="{{ $collection->meta['img_url'] }}" alt="{{ $collection->title }}">
                            @endif
                        </div>
                        <div class="tile">
                            <input type="checkbox" id="published" name="published" value="1" {{ isset($collection->meta['published']) && $collection->meta['published'] == 1 ? 'checked' : '' }}>
                            <label for="published">Published</label>
                            @if(isset($collection->id))
                                <button type="submit" class="btn">Update</button>
                            @else
                                <button type="submit" class="btn">Save</button>
                            @endif
                        </div>
                    </div>
                </form>
        @endsection
