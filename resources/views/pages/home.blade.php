@extends('layouts.default' ,
['title' => 'Home',
'description' => 'Mark Sutherland is a Developer and Digital Creative based in Leicester, UK.']
)
@section('content')
    <section id="intro">
        <div class="third-split h-card">
            <div class="avatar-box mb-3">
                @if ($latest_photo)
                    <button class="avatar-surround" popovertarget="latest-photo">
                        <img src="{{ config('app.url') }}/images/avatar.jpg" alt="Mark Sutherland"
                             class="avatar u-photo" height="416" width="416">
                    </button>
                    <div popover id="latest-photo">
                        <div id="latest-photo-header">
                            <small class="timestamp"><i class="fas fa-clock"></i>
                                <time
                                    datetime="{{ $latest_photo->published_at }}">{{ $latest_photo->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}</time>
                            </small>
                            <button type="button" popovertarget="latest-photo" popovertargetaction="hide"
                                    class="btn btn-close" title="close"><i class="fa-solid fa-times"></i></button>
                        </div>
                        <figure>
                            <img src="/storage/photos/{{ $latest_photo->meta['img_url'] }}"
                                 alt="{{ $latest_photo->title }}">
                            <figcaption>{{ $latest_photo->title }}
                                @if ($latest_photo->meta['location'] != null)
                                    <br><small><i
                                            class="fa-solid fa-location-dot"></i> {{ $latest_photo->meta['location'] }}
                                    </small>
                                @endif
                            </figcaption>
                        </figure>
                    </div>
                @else
                    <img src="{{ config('app.url') }}/images/avatar.jpg" alt="Mark Sutherland" class="avatar u-photo"
                         height="416" width="416">
                @endif
            </div>
            <div>
                <div class="box">
                    <h1 class="p-name">Mark Sutherland</h1>
                    <p class="p-note box-mid"><span class="p-category">Developer</span> & Digital Creative</p>
                    <p class="box-mid"><i class="fa-solid fa-location-dot"></i>
                        <span class="p-locality">Leicester</span>,
                        <span class="p-country-name">UK</span>
                        <i class="fa-solid fa-user"></i>
                        <span class="p-pronouns box-divider">He/Him</span></p></div>
                <nav id="social-links" class="elsewhere" aria-label="Social links">
                    <a class="u-url u-uid" href="{{ config('app.url') }}" rel="me" aria-label="Website"><i class="fa-solid fa-globe" aria-hidden="true"></i></a>
                    <a class="u-email" href="mailto:mark@marksuth.dev" rel="me" aria-label="Email"><i class="fa-solid fa-envelope" aria-hidden="true"></i></a>
                    <a href="https://github.com/marksuth" rel="me" aria-label="GitHub"><i class="fa-brands fa-github" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/in/marksuth" rel="me" aria-label="Linkedin"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                    <a href="https://mastodon.social/@marksuth" rel="me" aria-label="Mastodon"><i class="fa-brands fa-mastodon" aria-hidden="true"></i></a>
                    <a href="https://codepen.io/marksuth" rel="me" aria-label="CodePen"><i class="fa-brands fa-codepen" aria-hidden="true"></i></a>
                    <a href="https://www.discogs.com/user/marksuth" rel="me" aria-label="Discogs"><i class="fa-solid fa-record-vinyl" aria-hidden="true"></i></a>
                    <a href="https://letterboxd.com/marksuth/" rel="me" aria-label="Letterboxd"><i class="fa-brands fa-letterboxd" aria-hidden="true"></i></a>
                </nav>
            </div>
        </div>
    </section>
    <section id="feed">
        <h2 class="fancy-title">Recent Posts</h2>
        <div class="h-feed">
            @forelse($posts as $post)
                <article class="post hentry h-entry">
                    <small><a class="p-category"
                              href="/posts/type/{{ strtolower($post->post_type->name) }}">{{ $post->post_type->name }}</a>
                        posted
                        <time datetime="{{ $post->published_at }}" class="dt-published">
                            @if($post->published_at->diffInWeeks(now()) < 6)
                                {{ $post->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                            @else
                                {{ $post->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                            @endif
                        </time>
                    </small><br>
                    <h2 class="p-name"><a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}">
                            {{ $post->title }}</a></h2>
                    <div class="e-content">
                        {!! Str::markdown(Str::words("$post->content", 30, ' ...')) !!}
                    </div>
                    <footer>

                        <a href="/posts/{{ $post->published_at->format('Y/m') }}/{{ $post->slug }}"
                           class="btn btn-right u-url" title="View {{ $post->post_type->name }}">View
                            {{ $post->post_type->name }} <i class="fa-solid fa-chevron-right"></i></a>
                    </footer>
                </article>
            @empty
                <p>No posts found</p>
            @endforelse
            <a href="/posts" class="btn">View All Posts <i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </section>
    <div class="half-split">
        <section id="activity-stream">
            <h2 class="fancy-title">Activity Stream</h2>
            <div class="tile tile-alt">
                <ul>
                    @forelse($activities as $activity)
                        <li>
                            <small><a
                                    href="/posts/type/{{ strtolower($activity->post_type->name) }}">{{ $activity->post_type->name }}</a>
                                posted
                                <time datetime="{{ $activity->published_at }}">
                                    @if($activity->published_at->diffInWeeks(now()) < 6)
                                        {{ $activity->published_at->tz(env('APP_TIMEZONE'))->diffForHumans() }}
                                    @else
                                        {{ $activity->published_at->tz(env('APP_TIMEZONE'))->format('d/m/y @ H:m') }}
                                    @endif </time>
                            </small>
                            <h3><a
                                    href="/posts/{{ $activity->published_at->format('Y/m') }}/{{ $activity->slug }}">{{ $activity->title }}</a>
                            </h3>
                        </li>
                    @empty
                        <li class="py-3">No activity to display</li>
                @endforelse
            </ul>
            </div>
            <a href="/stream" class="btn">
                View Activity Stream <i class="fa-solid fa-chevron-right"></i>
            </a>
        </section>
        <section id="photo-stream">
            <h2 class="fancy-title">Photo Stream</h2>
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
                    <p>No photos found</p>
                @endforelse
            </ul>
            <p><a href="/photos" class="btn">View All Photos <i class="fa-solid fa-chevron-right"></i></a>
            </p>
        </section>
    </div>
        @endsection
        @section('extrascripts')
            <script>
                const pattern = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
                let current = 0;
                const audio = new Audio('/images/Halvorsen-ctrl_z.mp3');

                const keyHandler = function (event) {
                    if (pattern.indexOf(event.key) < 0 || event.key !== pattern[current]) {
                        current = 0;
                        return;
                    }
                    current++;

                    if (pattern.length === current) {
                        current = 0;
                        audio.play();
                        document.querySelector('.avatar').classList.add('spin');
                        setTimeout(() => {
                            document.querySelector('.avatar').classList.remove('spin');
                        }, 8594);
                    }

                };
                document.addEventListener('keydown', keyHandler, false);
            </script>
            <style>
                .spin {
                    animation: spin 2s infinite linear;
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }
                    100% {
                        transform: rotate(360deg);
                    }
                }
            </style>
@endsection
