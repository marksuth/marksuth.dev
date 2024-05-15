@extends('layouts.backend', [
    'title' => 'Page Editor',
])
@section('content')
    <h1>{{ $page->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif
    @if(isset($page->id))
        @if($page->meta['published'])
            <p><a href="/posts/{{ $page->published_at->format('Y/m') }}/{{ $page->slug }}"
                  target="blank" class="btn">View Page ></a></p>
        @endif
        <form action="{{ route('backend.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.pages.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="editor-split">
                        <div class="tile">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title"
                                   value="{{ $page->title ?? '' }}">
                            <label for="content">Content</label>
                            <textarea id="content" name="content" rows="20">{{ $page->content ?? '' }}</textarea>
                        </div>
                        <div class="tile">
                            <label for="published_at">Publish at</label>
                            <input type="datetime-local" id="published_at"
                                   name="published_at"
                                   value="{{ isset($page->published_at) ? $page->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">
                            <input type="checkbox" id="published"
                                   name="published"
                                   value="1" {{ isset($page->meta['published']) && $page->meta['published'] == 1 ? 'checked' : '' }}>
                            <label for="published">Published</label>
                            @if(isset($page->id)  && $page->meta['published'] == 1)
                                <button type="submit" class="btn">Update Page</button>
                            @elseif(isset($page->id) && $page->meta['published'] != 1)
                                <button type="submit" class="btn">Update Draft</button>
                            @else
                                <button type="submit" class="btn">Save Page</button>
                            @endif
                        </div>
                    </div>
                </form>
        @endsection
