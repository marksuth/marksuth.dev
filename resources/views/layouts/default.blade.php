<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title . ' - ' . config('app.name')}}</title>
    <meta name="description" content="{{ $description }}">
    <meta property="og:locale" content="en_GB">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{config('app.name')  . ' - ' . $title}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (Str::startsWith($current = url()->current(), 'https://www.'))
        <meta property="og:url" content="{{ strtolower(str_replace('https://www.', 'https://', $current)) }}">
    @else
        <meta property="og:url" content="{{ strtolower($current) }}">
    @endif
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:image" content="{{ config('app.url') }}/images/@yield('ogimg', 'opengraph.jpg')">
    <meta property="og:image:secure_url" content="{{ config('app.url') }}/images/@yield('ogimg', 'opengraph.jpg')">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:title" content="{{config('app.name')  . ' - ' . $title}}">
    <meta name="twitter:site" content="@marksuth">
    <meta name="twitter:image" content="{{ config('app.url') }}/images/opengraph.jpg">
    <meta name="twitter:creator" content="@marksuth">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="copyright" content="{{ config('app.name') }}">
    <meta name="theme-color" content="#214154">
    @yield('metatags')
    @if (Str::startsWith($current = url()->current(), 'https://www.'))
        <link rel="canonical" href="{{ strtolower(str_replace('https://www.', 'https://', $current)) }}">
    @else
        <link rel="canonical" href="{{ strtolower($current) }}">
    @endif
    <link rel="me" href="https://github.com/marksuth">
    <link rel="me" href="https://twitter.com/marksuth">
    <link rel="me" href="https://www.instagram.com/marksuth">
    <link rel="me" href="https://www.linkedin.com/in/marksuth">
    <link rel="me" href="https://medium.com/@marksuth">
    <link rel="me" href="https://letterboxd.com/marksuth">
    <link rel="author" href="{{ config('app.url') }}">
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.posts') }}"
          title="{{ config('app.name') }} - Posts">
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.photos') }}"
          title="{{ config('app.name') }} - Photos">
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.stream') }}"
          title="{{ config('app.name') }} - Stream">
    <link rel="icon" type="image/png" href="{{ config('app.url') }}/images/icon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/icons/icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/icons/icon-16.png">
    <link rel="manifest" href="{{ route('webmanifest') }}">
    <link rel="openid.delegate" href="{{ config('app.url') }}/">
    <link rel="openid.server" href="https://openid.indieauth.com/openid">
    <link rel="webmention" href="https://webmention.io/marksuth.dev/webmention">
    <link rel="pingback" href="https://webmention.io/marksuth.dev/xmlrpc">
    <link rel="authorization_endpoint" href="https://indieauth.com/auth">
    <link rel="token_endpoint" href="https://tokens.indieauth.com/token">
    <link rel="microsub" href="https://aperture.p3k.io/microsub/658">
    @vite(['resources/sass/style.scss', 'resources/js/app.js'])
</head>
<body>
<nav id="navbar" aria-label="main-navigation">
    <div class="tube">
        <a class="logo" href="{{ config('app.url') }}" rel="author">{{ config('app.name') }}</a>
        <section><label for="main-nav" class="btn-menu inline-toggle"><i class="fa-solid fa-bars"></i></label><input
                type="checkbox" id="main-nav" class="inline-toggle">
            <nav>
                <a class="@if($current == config('app.url'))active @endif" href="/">Home</a>
                <a class="@if(Request::segment(1) == 'now') active @endif" href="/now">Now</a>
                <a class="@if(Request::segment(1) == 'posts') active @endif" href="{{ route('posts') }}">Posts</a>
                <a class="@if(Request::segment(1) == 'photos') active @endif" href="{{ route('photos') }}">Photos</a>
                <a class="@if(Request::segment(1) == 'collections') active @endif" href="{{ route('collections') }}">Collections</a>
                <a class="@if (Request::segment(1) == 'stream') active @endif"
                   href="{{ route('posts.stream') }}">Stream</a>
                <a class="@if (Request::segment(1) == 'projects') active @endif" href="/projects">Projects</a>
                @if (Auth::check())
                    <a href="{{ route('backend.index') }}"><i class="fa-solid fa-gear"></i></a>
                    <a href="{{ route('logout') }}" title="Logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                @endif
            </nav>
        </section>
    </div>
</nav>
<div class="tube">
    <div id="search-box">
        <form action="{{ route('search.search') }}" method="GET" class="search-form">
            <input type="search" name="query" id="query" placeholder="Search..." value="{{ request('query') }}"
                   class="form-control">
            <button type="submit" class="btn"><i class="fa-solid fa-search"></i></button>
        </form>
    </div>
    <main class="site-main">
        @yield('content')
    </main>
</div>
@yield('strap')
<footer class="site-footer">
    <div class="tube">
        <div class="split">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" id="footer-logo" viewBox="0 0 300 145">
                    <path
                        d="M58.86 116.36c-.71 2.36-2.94 3.05-4.7.62-1.44-1.99-2.7-4.44-3.04-6.83-.96-6.9-1.81-13.86-1.97-20.81-.2-9.03.3-18.08.51-27.3-.82 2.48-1.56 4.88-2.41 7.24-1.1 3.06-2.23 6.11-3.44 9.12-.47 1.17-1.1 2.3-1.83 3.33-2.6 3.72-6.6 3.48-8.23-.78-1.2-3.13-2.13-6.59-2.16-9.91-.15-14.99.06-29.99.15-44.98 0-.47.06-.94-.26-1.54-.34.82-.7 1.64-1.01 2.47-7.25 19.62-12.03 39.91-16.62 60.27-1.71 7.57-4.02 15-6.16 22.46-.38 1.34-1.14 2.64-1.99 3.75-.99 1.28-2.41 1.55-3.76.44-2.68-2.19-2.6-11.37.36-14.06-.12 1.97-.37 3.7-.28 5.41.09 1.73.5 3.45.77 5.18l.86.03c.89-3.26 1.9-6.48 2.64-9.77C9.65 85.85 12.7 70.93 16.3 56.14c3.73-15.35 8.59-30.37 14.64-44.97.48-1.17.9-2.49 1.75-3.33.8-.79 2.28-1.59 3.21-1.37 1.06.25 2.36 1.51 2.63 2.57.47 1.87.35 3.93.29 5.9-.48 16.58-1.08 33.16-1.47 49.74-.1 4.01.43 8.03.66 12.05l.7.15c.51-1.08 1.15-2.13 1.52-3.26 3.14-9.57 6.22-19.15 9.33-28.73.81-2.49 1.62-4.98 2.5-7.44.61-1.68 1.66-2.99 3.68-2.69 2.14.31 2.92 1.96 2.82 3.81-.29 5.15-.77 10.28-1.2 15.42-1.35 16.06-2.62 32.13-1.6 48.27.23 3.71.8 7.41 1.38 11.09.14.87.9 1.64 1.72 3.04ZM253.88 86.45c1.27-4.8 2.44-9.64 3.85-14.4 1.33-4.48 2.88-8.89 4.4-13.31.33-.96.88-1.87 1.47-2.71 2.24-3.24 5.62-3.32 7.72-.02 1.26 1.99 2.09 4.26 3.01 6.44 1.69 4.02 3.05 8.19 4.99 12.08 4.33 8.68 10.24 16 19.05 20.58.46.24.84.66 1.63 1.3-2.69 1.29-5.29 1.53-7.51.52-3.11-1.43-6.22-3.2-8.76-5.46-6.17-5.5-10.01-12.61-12.7-20.37-1.29-3.72-2.55-7.44-3.83-11.15-.27-.03-.53-.07-.8-.1-1.31 4.12-2.81 8.18-3.9 12.36-1.58 6.06-2.82 12.2-4.29 18.29-.35 1.45-.72 3.07-1.61 4.17-.95 1.17-2.52 2.46-3.84 2.5-1.19.03-3.07-1.32-3.52-2.5-1.16-2.99-2.24-6.21-2.36-9.37-.37-9.98-.65-19.98-.28-29.95.52-13.87 1.61-27.72 2.57-41.57.24-3.55.86-7.08 1.36-10.61.23-1.61.59-3.37 2.76-3.14 2.06.22 2.01 2.08 1.98 3.52-.06 3.49-.38 6.97-.52 10.45-.81 19.74-1.66 39.47-2.36 59.22-.13 3.63.36 7.28.6 10.92.05.77.27 1.52.42 2.28.16.01.32.03.48.04ZM194.4 1.03c-1.21.72-2.41 1.44-3.63 2.15-8.34 4.81-14.51 11.71-19.22 20-6.78 11.95-12.02 24.48-13.81 38.23-.24 1.86-.19 3.82.08 5.68.7 5 2.85 6.81 7.88 7.14 3.95.26 7.94.37 11.83 1 10.83 1.75 15.68 9.28 12.21 19.66-1.79 5.35-4.27 10.68-7.44 15.34-7.3 10.75-15.21 21.09-22.91 31.57-.74 1.01-1.66 1.99-2.72 2.62-.83.49-2 .42-3.02.6-.13-.97-.65-2.1-.33-2.88.86-2.11 1.89-4.21 3.19-6.08 4.12-5.93 8.49-11.68 12.56-17.63 4.25-6.21 8.4-12.51 12.31-18.93 1.54-2.53 2.6-5.45 3.39-8.33 1.34-4.84-.5-8.41-5.3-9.87-3.29-1-6.82-1.24-10.26-1.73-1.72-.25-3.48-.21-5.2-.44-7.12-.96-10.91-5.14-11.37-12.39-.39-6.11.73-12.01 2.37-17.84 3.28-11.7 8.04-22.71 15.09-32.66 5.14-7.25 11.67-12.7 20.27-15.36 1.22-.38 2.54-.4 3.82-.58l.21.76Z"
                        class="cls-1"/>
                    <path
                        d="M155.35 98.01c-3.97-.13-7.95-.29-11.94-.39-4.66-.11-8.55-1.59-11.01-6.56-1.41 3.36-2.62 6.29-3.87 9.22-.59 1.38-1 2.94-1.94 4.04-.77.89-2.33 1.83-3.3 1.62-1.12-.24-2.42-1.55-2.82-2.69-.59-1.66-.72-3.61-.57-5.4.71-8.93 1.26-17.89 2.45-26.77 2.29-17.21 4.97-34.38 7.5-51.56.21-1.41.6-2.79.88-4.19.3-1.52.85-2.86 2.73-2.58 1.86.28 2.11 1.82 2 3.27-.25 3.32-.59 6.64-1.01 9.94-2.58 20.3-5.2 40.6-7.79 60.9-.16 1.29-.17 2.61.2 4.02.38-.74.75-1.47 1.14-2.2 4.21-7.99 8.42-15.99 12.65-23.97.4-.76.82-1.71 1.5-2.08.87-.48 2.22-.9 2.99-.55.75.35 1.37 1.71 1.4 2.64.04 1.02-.6 2.09-1.05 3.09-1.92 4.26-3.91 8.49-5.82 12.75-.45 1.01-.74 2.09-1.02 3.16-1.37 5.16-.11 7.27 5.05 8.38 2.24.48 4.54.74 6.75 1.33 3.09.83 4.8 2.64 4.91 4.56ZM226.28 6.76c-.56 1.84-1.3 3.48-1.53 5.18-1.74 13.05-3.39 26.11-5.05 39.17-.06.45 0 .91 0 1.65 3.35-1.84 6.46-3.54 9.57-5.25.21.29.41.58.62.87-3 2.75-5.9 5.61-9.05 8.19-1.36 1.11-2.03 2.2-2.15 3.93-.48 6.89-1.2 13.76-1.58 20.65-.2 3.63.05 7.29.21 10.93.05 1.13.51 2.24.92 3.94 8.35-6.6 13.09-15.63 20.27-23.37 0 1.73.28 3.05-.04 4.19-2.67 9.29-8.08 16.87-15.38 22.98-4.77 3.99-9.92 2.14-11.01-3.95-.84-4.72-1.17-9.65-.82-14.43 1.53-20.97 3.98-41.85 7.97-62.52.71-3.7 2.04-7.32 3.46-10.82.93-2.29 2.23-2.41 3.6-1.33ZM91.52 101.22c-1.16 1.04-2.46.66-3.41-.41-1.14-1.28-2.35-2.69-2.91-4.27-1.62-4.54-2.93-9.19-4.35-13.81-.23-.75-.39-1.52-.69-2.73-.77 3.33-1.22 6.28-2.17 9.06-.81 2.36-1.88 4.76-3.41 6.7-2.35 2.98-6.08 2.35-7.67-1.12-.68-1.48-1.16-3.17-1.25-4.79-.42-7.55-.07-15.06 1.78-22.44.23-.92.53-1.83.87-2.71 1.92-5.06 3.63-5.97 8.86-4.68.06-1.04.1-2.05.17-3.07.11-1.57.62-2.85 2.45-2.93 1.95-.09 2.64 1.27 2.82 2.88.42 3.7.65 7.43 1.1 11.12 1.2 9.84 2.44 19.68 5.72 29.1.47 1.34 1.29 2.56 2.09 4.09Zm-20.46-8.53.81.18c.75-1.83 1.88-3.6 2.17-5.5 1.16-7.74 2.08-15.52 3.02-23.29.06-.53-.57-1.65-.77-1.63-.93.12-2.12.29-2.64.92-.71.86-1.02 2.13-1.29 3.27-1.82 7.7-2.21 15.52-1.89 23.39.04.89.39 1.77.6 2.66ZM196.28 63.92c-1.15 1.62-2.25 3.33-3.51 4.9-1.53 1.9-3.36 3.6-6.03 3.07-2.79-.56-3.97-2.85-4.34-5.39-1.43-9.87.48-19.06 5.9-27.48.33-.52.82-1.1 1.36-1.28.74-.25 1.61-.15 2.42-.2-.11.7-.03 1.49-.34 2.09-3.61 6.88-5.27 14.24-5.3 21.96 0 1.76.51 3.52.91 6.02 1.23-1.21 2.01-1.81 2.58-2.57 3.87-5.19 6.04-11.1 7.28-17.39.06-.31.08-.63.15-.94.41-1.75.82-3.64 3.21-3.3 2.41.35 2.26 2.3 2.11 4.07-.84 9.86-.5 19.65 1.87 29.3.25 1.02 1 1.91 1.75 3.29-.84 1.65-2.46 2.14-4.22.33-1.23-1.26-2.34-2.89-2.85-4.56-1.17-3.84-1.95-7.81-2.94-11.93ZM99.57 68.88c4.42-8.28 11.28-13.8 19.39-17.91.17.15.34.3.51.44-.73.95-1.44 1.93-2.21 2.85-2.98 3.61-6.01 7.17-8.95 10.81-4.46 5.53-6.46 11.93-6.5 18.98-.02 3.33 0 6.67.02 10 .02 1.78-.51 3.29-2.49 3.42-1.99.13-2.69-1.31-2.86-3.08-.93-9.87-1.93-19.73-2.75-29.6-.18-2.18.02-4.47.53-6.59.21-.86 1.69-1.95 2.64-1.99 1.67-.07 1.66 1.47 1.63 2.82-.06 3.21-.02 6.42-.02 9.63.35.07.7.14 1.05.22Z"
                        class="cls-1"/>
                </svg>
                <small>&copy; Mark Sutherland {{ date('Y') }}. 🌈</small>
                <nav class="footer-nav">
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/contact">Contact Me</a>
                </nav>
            </div>
            <p>
                <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/previous" title="Webring Previous"
                   aria-label="Webring Previous"><i class="fa-solid fa-chevron-left"></i></a>
                An IndieWeb Webring
                <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/next" title="Webring Next"
                   aria-label="Webring Next"><i class="fa-solid fa-chevron-right"></i></a>
            </p>
        </div>
    </div>

</footer>
@yield('extrascripts')
<script async defer src="https://scripts.withcabin.com/hello.js"></script>
</body>
</html>
