@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1 class="py-3">{{ $post->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-error my-0">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($post->id))
        @if($post->meta['published'])
            <p><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" target="blank"
                  class="btn btn-sm btn-link">View Post ></a></p>
        @endif
        <form action="{{ route('backend.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">
                                <div class="mb-3">
                                    <label for="title" class="h6">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $post->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="h6">Content</label>
                                    <textarea class="form-control" id="content" name="content"
                                              rows="20">{{ $post->content ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="h6">Post image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                           accept="image/*" value="{{ $post->meta['img_url'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="h6">Location</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                           value="{{ $post->meta['location'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-white">
                                <div class="mb-3">
                                    <label for="published_at" class="h6">Publish at</label>
                                    <input type="datetime-local" class="form-control" id="published_at"
                                           name="published_at"
                                           value="{{ isset($post->published_at) ? $post->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="published"
                                           name="published"
                                           value="1" {{ isset($post->meta['published']) && $post->meta['published'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="published">Published</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="distant_past"
                                           name="distant_past"
                                           value="1" {{ isset($post->meta['distant_past']) && $post->meta['distant_past'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="distant_past">Post from the distant
                                        past</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="near_future"
                                           name="near_future"
                                           value="1" {{ isset($post->meta['near_future']) && $post->meta['near_future'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="near_future">Post is in the near future</label>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="h6">Type</label>
                                    <select class="form-select" id="type" name="type">
                                        <option value="">Select a type</option>
                                        @forelse($post_types as $type)
                                            <option value="{{ $type->id }}" {{ isset($post->post_type_id) && $post->post_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @empty
                                            <option value="">No post types found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="mb-3 text-end">

                                    @if(isset($post->id)  && $post->meta['published'] == 1)
                                        <button type="submit" class="btn btn-primary">Update Post</button>
                                    @elseif(isset($post->id) && $post->meta['published'] != 1)
                                        <button type="submit" class="btn btn-primary">Update Draft</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">Save Post</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @vite(['resources/js/easymde.js', 'resources/sass/easymde.scss'])
        @endsection
