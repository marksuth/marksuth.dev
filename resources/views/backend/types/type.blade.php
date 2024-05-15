@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1 class="py-3">{{ $type->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-error my-0">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($type->id))
        @if($type->meta['published'])
            <p><a href="/types/{{ $type->slug }}" target="blank" class="btn btn-sm btn-link">View Post Type ></a></p>
        @endif
        <form action="{{ route('backend.types.update', $type->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.types.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">
                                <div class="mb-3">
                                    <label for="title" class="h6">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $type->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="h6">Description</label>
                                    <textarea class="form-control" id="content" name="content"
                                              rows="5">{{ $type->description ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="published"
                                           name="published"
                                           value="1" {{ isset($type->meta['published']) && $type->meta['published'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="published">Published</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="distant_past"
                                           name="distant_past"
                                           value="1" {{ isset($type->meta['distant_past']) && $type->meta['distant_past'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="distant_past">Enable the distant
                                        past</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="near_future"
                                           name="near_future"
                                           value="1" {{ isset($type->meta['near_future']) && $type->meta['near_future'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="near_future">Enable the near future</label>
                                </div>
                                <div class="mb-3 text-end">
                                    @if(isset($type->id)  && $type->meta['published'] == 1)
                                        <button type="submit" class="btn btn-primary">Update Post Type</button>
                                    @elseif(isset($type->id) && $type->meta['published'] != 1)
                                        <button type="submit" class="btn btn-primary">Update Draft</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">Save Post</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @endsection
