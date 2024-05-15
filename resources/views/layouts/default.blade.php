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
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.posts') }}" title="{{ config('app.name') }} - Posts">
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.photos') }}" title="{{ config('app.name') }} - Photos">
    <link rel="alternate" type="application/rss+xml" href="{{ route('feeds.stream') }}" title="{{ config('app.name') }} - Stream">
    <link rel="icon" type="image/png" href="{{ config('app.url') }}/images/icon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/icons/icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/icons/icon-16.png">
    <link rel="manifest" href="{{ config('app.url') }}/site.webmanifest">
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
        <section><label for="main-nav" class="btn-menu inline-toggle"><i class="fa-solid fa-bars"></i></label><input type="checkbox" id="main-nav" class="inline-toggle">
        <nav>
            <a class="@if($current == config('app.url'))active @endif" href="/">Home</a>
            <a class="@if(Request::segment(1) == 'now') active @endif" href="/now">Now</a>
            <a class="@if(Request::segment(1) == 'posts') active @endif" href="{{ route('posts') }}">Posts</a>
            <a class="@if(Request::segment(1) == 'photos') active @endif" href="{{ route('photos') }}">Photos</a>
            <a class="@if(Request::segment(1) == 'collections') active @endif" href="{{ route('collections') }}">Collections</a>
            <a class="@if (Request::segment(1) == 'stream') active @endif" href="{{ route('posts.stream') }}">Stream</a>
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
    <main class="site-main">
        @yield('content')
    </main>
</div>
@yield('strap')
<footer class="site-footer">
    <p>
        <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/previous" title="Webring Previous" aria-label="Webring Previous"><i class="fa-solid fa-chevron-left"></i></a>
        An IndieWeb Webring
        <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/next" title="Webring Next" aria-label="Webring Next"><i class="fa-solid fa-chevron-right"></i></a>
    </p>
    <small>&copy; Mark Sutherland {{ date('Y') }}. 🌈</small>
    <nav class="footer-nav">
        <a href="/privacy">Privacy Policy</a>
        <a href="/contact">Contact Me</a>
    </nav>
</footer>
@yield('extrascripts')
<script async defer src="https://scripts.withcabin.com/hello.js"></script>
</body>
</html>
