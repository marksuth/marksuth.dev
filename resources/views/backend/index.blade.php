@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <h1>Welcome back, {{ Auth::user()->name }}</h1>
    <div class="half-split">
        <section id="latest-photos">
            <h2>Latest Photos</h2>
            <a href="{{ route('backend.photos.create') }}" class="btn btn-primary">New Photo</a>
            <ul class="tile-grid tile-grid-sm">
                @forelse($photos as $photo)
                    <li class="tile">
                        <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                            <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}"
                                 alt="{{ $photo->title }}">
                        </a>
                        <p>
                            <time datetime="{{ $photo->published_at }}">
                                @if($photo->published_at->diffInWeeks(now()) < 6)
                                    {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                @else
                                    {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                                @endif </time>
                        </p>
                    </li>
                @empty
                    <li>No photos yet.</li>
                @endforelse
            </ul>
            <a href="{{ route('backend.photos') }}" class="btn">View All Photos</a>
        </section>
        <section id="latest-posts">
            <h2>Posts</h2>
            <a href="{{ route('backend.posts.create') }}" class="btn">New Post</a>
            <div class="tile">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->post_type->name }}</td>
                            <td><a href="{{ route('backend.posts.edit', $post->id) }}">{{ $post->title }}</a></td>
                            <td>
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
                            <td colspan="3">No posts yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('backend.posts') }}" class="btn btn-dark btn-sm">View All Posts</a>
        </section>
    </div>
@endsection
