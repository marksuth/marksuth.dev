@extends('layouts.backend', [
    'title' => 'Note Editor',
])
@section('content')
    @if(isset($note->id))
        <form action="{{ route('backend.notes.update', $note->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form action="{{ route('backend.notes.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <h1>{{ $note->title ?? 'New Note' }}</h1>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="error">{{ $error }}</p>
                        @endforeach
                    @endif
                    @if(isset($note->id))
                        <button type="submit" class="btn">Update Note</button>
                    @else
                        <button type="submit" class="btn">Save Note</button>
                    @endif
                    <div class="tile">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ $note->title ?? '' }}">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" rows="20">{{ $note->content ?? '' }}</textarea>
                    </div>
                </form>
    @vite(['resources/js/easymde.js', 'resources/sass/easymde.scss'])
@endsection
