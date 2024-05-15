@extends('layouts.backend', [
    'title' => 'Post Editor',
])
@section('content')
    <h1>{{ $type->title ?? 'New Post' }}</h1>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif

    @if(isset($type->id))
        @if($type->meta['published'])
            <p><a href="/types/{{ $type->slug }}" target="blank" class="btn">View Post Type ></a></p>
        @endif
        <form action="{{ route('backend.types.update', $type->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.types.store') }}" method="POST" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="editor-split">
                        <div class="tile">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{ $type->title ?? '' }}">
                            <label for="content">Description</label>
                            <textarea id="content" name="content" rows="5">{{ $type->description ?? '' }}</textarea>
                        </div>
                        <div class="tile">
                            <input type="checkbox" id="published" name="published"
                                   value="1" {{ isset($type->meta['published']) && $type->meta['published'] == 1 ? 'checked' : '' }}>
                            <label for="published">Published</label>
                            <input type="checkbox" id="distant_past" name="distant_past"
                                   value="1" {{ isset($type->meta['distant_past']) && $type->meta['distant_past'] == 1 ? 'checked' : '' }}>
                            <label for="distant_past">Enable the distant past</label>
                            <input type="checkbox" id="near_future" name="near_future"
                                   value="1" {{ isset($type->meta['near_future']) && $type->meta['near_future'] == 1 ? 'checked' : '' }}>
                            <label for="near_future">Enable the near future</label>
                            @if(isset($type->id)  && $type->meta['published'] == 1)
                                <button type="submit" class="btn">Update Post Type</button>
                            @elseif(isset($type->id) && $type->meta['published'] != 1)
                                <button type="submit" class="btn">Update Draft</button>
                            @else
                                <button type="submit" class="btn">Save Post</button>
                            @endif
                        </div>
                    </div>
                </form>
        @endsection
