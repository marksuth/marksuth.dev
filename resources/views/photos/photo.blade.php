@extends('layouts.default',
[
    'title' => Str::limit($photo->title, 32, '...'),
    'description' => 'A photo of '.$photo->title . ' taken by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
    <article class="h-entry hentry photo tile">
        <img class="u-photo" src="/storage/photos/{{ $photo->meta['img_url'] }}"
             alt="{{ $photo->title }}">
        <div class="details">
            <div class="split">
                <h1 class="entry-title">{{ $photo->title }}</h1>
                @if ($photo->meta['location'] != null)
                    <p><i class="fa-solid fa-location-dot"></i> {{ $photo->meta['location'] }}</p>
                @endif
            </div>
            @if(isset($photo->content) && $photo->content != $photo->title)
                <x-markdown class="entry-description text-dark">{{ $photo->content }}</x-markdown>
            @endif
            <div class="split">
                <time class="dt-published created"
                      datetime="{{ $photo->published_at }}">{{ $photo->published_at->format('d/m/Y @ H:i') }}</time>
                <p class="links">Posted to:
                    &nbsp;<a href="/photos/{{ $photo->published_at->format('Y/m') }}/{{ $photo->slug }}"
                             class="u-url">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                    @if ($photo->meta['instagram_url'] != null)
                        <a href="{{ $photo->meta['instagram_url'] }}" class="u-syndication"
                           rel="syndication">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </p>
            </div>
    </article>

@endsection
