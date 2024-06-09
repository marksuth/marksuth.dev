@extends('layouts.default',
[
    'title' => 'Search',
    'description' => 'Search for posts on ' . config('app.name'),
])

@section('content')
        <h1 class="fancy-title">Search results for "{{$search }}"</h1>
        <ul class="tile-grid tile-grid-sm">
            @forelse($photos as $photo)
                <li class="tile tile-sm">
                    <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                        <img src="{{ $photo->thumbnail }}" alt="{{ $photo->title }}">
                    </a>
                </li>
            @empty
                <li>No photos found</li>
            @endforelse
        </ul>

@endsection

