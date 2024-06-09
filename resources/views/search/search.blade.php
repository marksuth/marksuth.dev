@extends('layouts.default',
[
    'title' => 'Search',
    'description' => 'Search for posts on ' . config('app.name'),
])

@section('content')
    <h1 class="fancy-title">Search results for "{{$search }}"</h1>

    <ul class="tile-grid tile-grid-sm">
        @forelse($photos as $photo)
            <li class="tile tile-sm ">
                <a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}">
                    <img loading="lazy" src="/storage/thumbs/{{ $photo->meta['img_url'] }}"
                         alt="{{ $photo->title }}" height="500" width="500">
                </a>
                <time datetime="{{ $photo->published_at }}">
                    @if($photo->published_at->diffInWeeks(now()) < 6)
                        {{ $photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @else
                        {{ $photo->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                    @endif
                </time>
            </li>
        @empty
            <li>No photos were found for "{{ $search }}"</li>
        @endforelse
    </ul>

    <div class="h-feed">
        @forelse($posts as $post)
            <article class="post hentry h-entry">
                <small><a href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>
                    posted
                                            <time datetime="{{ $post->published_at }}">
                                                @if($post->published_at->diffInWeeks(now()) < 6)
                                                    {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                                @else
                                                    {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                                                @endif
                                            </time>
                </small>
                <h2><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}">
                        {{ $post->title }}</a></h2>
                <x-markdown>
                    {!! Str::words("$post->content", 30, ' ...') !!}
                </x-markdown>
                <footer>

                    <a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" class="btn btn-right"
                       title="View {{ $post->post_type->name }}">View
                        {{ $post->post_type->name }} <i class="fa-solid fa-chevron-right"></i></a>
                </footer>
            </article>
        @empty
            <p>No posts were found for "{{ $search }}"</p>
        @endforelse

        {{ $posts->links() }}

    </div>

@endsection

