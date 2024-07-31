@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>Photos</h1>
        <div>
            <a href="{{ route('backend.photos.create') }}" class="btn btn-primary">New Photo</a>
        </div>
    </div>

    <div class="row">
        @forelse($photos as $photo)
            <div class="col-md-3">
                <div class="bg-white p-2 mb-4 rounded-1 shadow">
                    <div class="ratio ratio-1x1">
                        <a href="{{ route('backend.photos.show', $photo->id) }}" class="photo-thumb">
                            <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}" class="img-fluid rounded">
                        </a>
                    </div>
                    <p class="text-gray text-end small">
                        @if($photo->published_at->diffInWeeks(now()) <= 6 && $photo->meta['published'] == 1)
                            Published {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                        @elseif($photo->published_at->isFuture() && $photo->meta['published'] == 1)
                            Scheduled {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                        @elseif($photo->published_at->diffInWeeks(now()) > 6 && $photo->meta['published'] == 1)
                            Published {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:i') }}
                        @elseif($photo->meta['published'] == 0)
                            Draft
                        @endif
                    </p>
                    <nav class="text-end">
                        <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}"
                           class="btn btn-outline-primary btn-sm" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('backend.photos.show', $photo->id) }}" class="btn btn-outline-primary btn-sm"><i
                                class="fa-solid fa-pen"></i></a>
                        <a href="{{ route('backend.photos.destroy', $photo->id) }}" class="btn btn-danger btn-sm"><i
                                class="fa-solid fa-trash"></i></a>
                    </nav>
                </div>
            </div>
        @empty
            <div class="my-5 text-center">
                <p>No photos found</p>
            </div>
        @endforelse
    </div>
@endsection
