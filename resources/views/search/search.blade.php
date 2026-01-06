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
                    <img loading="lazy" src="{{ Storage::url('thumbs/' . $photo->meta['img_url']) }}"
                         alt="{{ $photo->title }}" height="500" width="500">
                </a>
                <time datetime="{{ $photo->published_at }}">
                    @if($photo->published_at->diffInWeeks(now()) < 6)
                        {{ $photo->published_at->tz(config('app.timezone'))->diffForHumans() }}
                    @else
                        {{ $photo->published_at->tz(config('app.timezone'))->format('d/m/y @ H:i') }}
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
                                                    {{ $post->published_at->tz(config('app.timezone'))->diffForHumans() }}
                                                @else
                                                    {{ $post->published_at->tz(config('app.timezone'))->format('d/m/y @ H:i') }}
                                                @endif
                                            </time>
                </small>
                <h2><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}">
                        {{ $post->title }}</a></h2>
                    {!! Str::markdown(Str::words("$post->content", 30, ' ...')) !!}
                <footer>

                    <a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}" class="btn btn-right"
                       title="View {{ $post->post_type->name }}">View
                        {{ $post->post_type->name }} <i class="fa-solid fa-chevron-right"></i></a>
                </footer>
            </article>
        @empty
            <p>No posts were found for "{{ $search }}"</p>
        @endforelse

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
    </div>

@endsection

