@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <h1>Photos</h1>
    <a href="{{ route('backend.photos.create') }}" class="btn btn-primary">New Photo</a>
    @forelse($photos as $photo)
        <ul class="tile-grid">
            <li class="tile">
                <a href="{{ route('backend.photos.show', $photo->id) }}">
                    <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}">
                </a>
                <p>
                    @if($photo->published_at->diffInWeeks(now()) <= 6 && $photo->meta['published'] == 1)
                        Published {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($photo->published_at->isFuture() && $photo->meta['published'] == 1)
                        Scheduled {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @elseif($photo->published_at->diffInWeeks(now()) > 6 && $photo->meta['published'] == 1)
                        Published {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                    @elseif($photo->meta['published'] == 0)
                        Draft
                    @endif
                </p>
                <nav>
                    <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}"
                       class="btn" target="_blank"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{ route('backend.photos.show', $photo->id) }}" class="btn"><i
                            class="fa-solid fa-pen"></i></a>
                    <a href="{{ route('backend.photos.destroy', $photo->id) }}" class="btn"><i
                            class="fa-solid fa-trash"></i></a>
                </nav>
            </li>
        </ul>
    @empty
        <p>No photos found</p>
    @endforelse
@endsection
