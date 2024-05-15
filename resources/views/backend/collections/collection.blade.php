@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1 class="py-3">{{ $collection->title ?? 'New Collection' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-error my-0">{{ $error }}</p>
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
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">
                                <div class="mb-3">
                                    <label for="name" class="h6">Collection Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $collection->name ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="h6">Description</label>
                                    <textarea class="form-control" id="content" name="content"
                                              rows="5">{{ $collection->description ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="h6">Collection cover</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                           accept="image/*" value="{{ $post->meta['img_url'] ?? '' }}">
                                </div>
                                @if (isset($collection->meta['img_url']))
                                    <div class="mb-3">
                                        <img src="{{ $collection->meta['img_url'] }}" alt="{{ $collection->title }}"
                                             class="img-fluid">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="published"
                                           name="published"
                                           value="1" {{ isset($collection->meta['published']) && $collection->meta['published'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="published">Published</label>
                                </div>
                                <div class="mb-3 text-end">
                                    @if(isset($collection->id))
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @endsection
