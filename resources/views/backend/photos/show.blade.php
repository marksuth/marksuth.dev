@extends('layouts.backend', [
    'title' => $photo ?? null ? 'Show Photo' : 'Photo Details',
    'description' => '',
])

@section('content')
    <div class="container">
        <h1>{{ $photo->title }}</h1>

        @if(isset($photo->meta['path']))
            <div class="photo-preview" style="margin-bottom: 20px;">
                <img src="{{ Storage::url($photo->meta['path']) }}" alt="{{ $photo->title }}" style="max-width: 100%;">
            </div>
        @endif

        <div class="photo-details">
            <p><strong>Slug:</strong> {{ $photo->slug }}</p>
            <p><strong>Published At:</strong> {{ $photo->published_at ? $photo->published_at->format('Y-m-d H:i') : 'N/A' }}</p>
            <p><strong>Content:</strong></p>
            <div>{{ $photo->content }}</div>
        </div>

        <div class="actions" style="margin-top: 20px;">
            <a href="{{ route('backend.photos.edit', $photo) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('backend.photos.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
