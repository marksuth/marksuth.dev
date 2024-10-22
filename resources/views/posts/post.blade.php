@extends('layouts.default',
[
    'title' => Str::limit($post->title, 32, '...'),
    'description' => $post->title . ', a ' . $post->post_type->name . ' posted by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('metatags')
    <meta property="og:type" content="article"/>
    <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}"/>
@endsection
@section('content')
    <article class="h-entry hentry">
        <header class="page-header">

            <small class="lozenge"><a class="p-category category"
                                      href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>
                <time datetime="{{ $post->published_at }}" class="dt-published timestamp">
                    @if($post->published_at->diffInWeeks(now()) < 6)
                        {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                    @else
                        {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:i') }}
                    @endif
                </time>
            </small>
            <div class="page-title">
                <h1 class="p-name">{{ $post->title }}</h1>
            </div>
        </header>
        <div class="post">
            <div class="entry-content e-content">
                {!! Str::markdown($post->content) !!}
            </div>
            @if(isset($post->meta['location']))
                <small><i class="fa-solid fa-location-dot"></i> {{ $post->meta['location'] }}</small>
            @endif
            <footer class="entry-meta">
                <a class="p-category"
                        href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>@if($post->distant_past != '1')
                        posted
                    @else
                        imported
                    @endif
                    <time class="dt-published"
                          datetime="{{ $post->published_at->tz(env('APP_TIMEZONE'))->toRfc2822String() }}">{{ Carbon\Carbon::parse($post->published_at)->format('d/m/Y @ H:i') }}</time>
                    by <span class="h-card"><img src="https://marksuth.dev/images/avatar.jpg" alt="Mark Sutherland"
                                                 class="tiny-avatar u-photo" height="20" width="20" loading="lazy"/> <a
                            href="https://marksuth.dev" class="p-author" rel="author">Mark Sutherland</a></span>
                    @if($post->updated_at > $post->published_at)
                        <br><i>Last updated
                            <time class="dt-updated"
                                  datetime="{{ $post->updated_at->tz(env('APP_TIMEZONE'))->toRfc2822String() }}">{{ Carbon\Carbon::parse($post->updated_at)->format('d/m/Y @ H:i') }}</time>
                        </i>
                    @endif

                    <nav class="links">Posted to:
                    &nbsp;<a
                        href="@if (Str::startsWith($current = url()->current(), 'https://www')){{ str_replace('https://www.', 'https://', $current) }}@else{{ $current }}@endif"
                        class="u-url"><i class="fa-solid fa-globe"></i></a>
                    </nav>
            </footer>
        </div>
    </article>
@endsection
