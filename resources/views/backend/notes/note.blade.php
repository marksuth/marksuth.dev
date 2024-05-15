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
                    <div class="row justify-content-between mb-4">
                        <div class="col-8">
                            <h1 class="py-3">{{ $note->title ?? 'New Note' }}</h1>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="text-error my-0">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-4 text-end">
                            @if(isset($note->id))
                                <button type="submit" class="btn btn-primary">Update Note</button>
                            @else
                                <button type="submit" class="btn btn-primary">Save Note</button>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white p-lg-3 rounded mb-4">
                        <div class="mb-3">
                            <label for="title" class="h6">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ $note->title ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="h6">Content</label>
                            <textarea class="form-control" id="content" name="content"
                                      rows="20">{{ $note->content ?? '' }}</textarea>
                        </div>
                    </div>
                </form>
        @vite(['resources/js/easymde.js', 'resources/sass/easymde.scss'])
        @endsection
