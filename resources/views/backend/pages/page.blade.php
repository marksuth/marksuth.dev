@extends('layouts.backend', [
    'title' => 'Page Editor',
])
@section('content')
    <h1 class="py-3">{{ $page->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-error my-0">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($page->id))
        @if($page->meta['published'])
            <p><a href="/posts/{{ $page->published_at->format('Y/m') }}/{{ $page->slug }}"
                  target="blank" class="btn btn-sm btn-link">View Page ></a></p>
        @endif
        <form action="{{ route('backend.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.pages.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card bg-white shadow-sm p-3 rounded mb-4">
                                <div class="mb-3">
                                    <label for="title" class="h6">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $page->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="h6">Content</label>
                                    <textarea class="form-control" id="content" name="content"
                                              rows="20">{{ $page->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-white">
                                <div class="mb-3">
                                    <label for="published_at" class="h6">Publish at</label>
                                    <input type="datetime-local" class="form-control" id="published_at"
                                           name="published_at"
                                           value="{{ isset($page->published_at) ? $page->published_at->format('Y-m-d H:i') : Carbon\Carbon::now()->tz(env('APP_TIMEZONE'))->format('Y-m-d H:i') }}">
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="published"
                                           name="published"
                                           value="1" {{ isset($page->meta['published']) && $page->meta['published'] == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="published">Published</label>
                                </div>

                                <div class="mb-3 text-end">
                                    @if(isset($page->id)  && $page->meta['published'] == 1)
                                        <button type="submit" class="btn btn-primary">Update Page</button>
                                    @elseif(isset($page->id) && $page->meta['published'] != 1)
                                        <button type="submit" class="btn btn-primary">Update Draft</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">Save Page</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @endsection
