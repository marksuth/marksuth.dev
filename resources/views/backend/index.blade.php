@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <h1 class="my-5">Welcome back, {{ Auth::user()->name }}</h1>
    <div class="row justify-content-between">
        <div class="col-lg-5">
            <div class="d-flex justify-content-between mb-4">
                <h2>Latest Photos</h2>
                <div>
                    <a href="{{ route('backend.photos.create') }}" class="btn btn-primary">New Photo</a>
                </div>
            </div>
            <div class="row">
                @forelse($photos as $photo)
                    <div class="col-4">
                        <div class="bg-white p-1 pb-0 mb-4 rounded-1">
                            <div class="ratio ratio-1x1">
                                <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}"
                                   class="photo-thumb">
                                        <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}" alt="{{ $photo->title }}" class="img-fluid rounded">
                                </a>
                            </div>
                            <p class="text-gray text-end small">
                                <time datetime="{{ $photo->published_at }}">
                                    @if($photo->published_at->diffInWeeks(now()) < 6)
                                        {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                    @else
                                        {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                                    @endif </time>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="my-5 text-center">
                        <p>No photos yet.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-end">
                <a href="{{ route('backend.photos') }}" class="btn btn-dark btn-sm">View All Photos</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-between mb-4">
                <h2>Posts</h2>
                <div>
                    <a href="{{ route('backend.posts.create') }}" class="btn  btn-dark">New Post</a>
                </div>
            </div>
            <div class="bg-white p-1 pb-0 mb-4 rounded-1">
                <table class="table-sm table-striped table-hover table-borderless">
                    <thead>
                    <tr>
                        <th class="col-1" scope="col">Type</th>
                        <th scope="col">Title</th>
                        <th class="col-3 text-end" scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="text-muted">{{ $post->post_type->name }}</td>
                            <td><a href="{{ route('backend.posts.edit', $post->id) }}">{{ $post->title }}</a></td>
                            <td class="text-end small">
                                @if($post->published_at->diffInWeeks(now()) <= 6 && $post->meta['published'] == 1)
                                    Published {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                @elseif($post->published_at->isFuture() && $post->meta['published'] == 1)
                                    Scheduled {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                @elseif($post->published_at->diffInWeeks(now()) > 6 && $post->meta['published'] == 1)
                                    Published {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                                @elseif($post->meta['published'] == 0)
                                    Draft
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No posts yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <a href="{{ route('backend.posts') }}" class="btn btn-dark btn-sm">View All Posts</a>
            </div>
        </div>
    </div>

@endsection
