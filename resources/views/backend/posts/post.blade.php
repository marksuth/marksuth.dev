@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1>{{ $post->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($post->id))
        @if($post->meta['published'])
            <p><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" target="blank"
                  class="btn">View Post ></a></p>
        @endif
        <form action="{{ route('backend.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="editor-split">
                        <div class="tile">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{ $post->title ?? '' }}">
                            <label for="content">Content</label>
                            <textarea id="content" name="content"
                                      rows="20">{{ $post->content ?? '' }}</textarea>
                            <label for="image">Post image</label>
                            <input type="file" id="image" name="image"
                                   accept="image/*" value="{{ $post->meta['img_url'] ?? '' }}">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location"
                                   value="{{ $post->meta['location'] ?? '' }}">
                        </div>
                        <div class="tile">
                            <label for="published_at">Publish at</label>
                            <input type="datetime-local" id="published_at"
                                   name="published_at"
                                   value="{{ isset($post->published_at) ? $post->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">

                            <input class="form-check-input" type="checkbox" id="published"
                                   name="published"
                                   value="1" {{ isset($post->meta['published']) && $post->meta['published'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="published">Published</label>
                            <input class="form-check-input" type="checkbox" id="distant_past"
                                   name="distant_past"
                                   value="1" {{ isset($post->meta['distant_past']) && $post->meta['distant_past'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="distant_past">Post from the distant past</label>
                            <input class="form-check-input" type="checkbox" id="near_future"
                                   name="near_future"
                                   value="1" {{ isset($post->meta['near_future']) && $post->meta['near_future'] == 1 ? 'checked' : '' }}>
                            <label for="near_future">Post is in the near future</label>
                            <label for="type">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Select a type</option>
                                @forelse($post_types as $type)
                                    <option
                                        value="{{ $type->id }}" {{ isset($post->post_type_id) && $post->post_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @empty
                                    <option value="">No post types found</option>
                                @endforelse
                            </select>
                            @if(isset($post->id)  && $post->meta['published'] == 1)
                                <button type="submit" class="btn">Update Post</button>
                            @elseif(isset($post->id) && $post->meta['published'] != 1)
                                <button type="submit" class="btn">Update Draft</button>
                            @else
                                <button type="submit" class="btn">Save Post</button>
                            @endif
                        </div>
                    </div>
                </form>
        @vite(['resources/js/easymde.js', 'resources/sass/easymde.scss'])
        @endsection
