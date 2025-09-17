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
    @env('staging')
        <meta name="robots" content="noindex, nofollow">
    @endenv
    @production
        <meta name="robots" content="index, follow">
    @endproduction
    @php $current = url()->current(); @endphp
    @if (Str::startsWith($current, 'https://www.'))
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
    @yield('metatags')
    @if (Str::startsWith($current, 'https://www.'))
        <link rel="canonical" href="{{ strtolower(str_replace('https://www.', 'https://', $current)) }}">
    @else
        <link rel="canonical" href="{{ strtolower($current) }}">
    @endif
    <link rel="me" href="https://github.com/marksuth">
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
    <link rel="icon" type="image/png" href="{{ config('app.url') }}/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="{{ config('app.url') }}/favicon.svg"/>
    <link rel="shortcut icon" href="{{ config('app.url') }}/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png"/>
    <link rel="manifest" href="{{ route('webmanifest') }}">
    <link rel="openid.delegate" href="{{ config('app.url') }}/">
    <link rel="openid.server" href="https://openid.indieauth.com/openid">
    <link rel="webmention" href="https://webmention.io/marksuth.dev/webmention">
    <link rel="pingback" href="https://webmention.io/marksuth.dev/xmlrpc">
    <link rel="authorization_endpoint" href="https://indieauth.com/auth">
    <link rel="token_endpoint" href="https://tokens.indieauth.com/token">
    <link rel="microsub" href="https://aperture.p3k.io/microsub/658">
    @vite(['resources/sass/style.scss', 'resources/js/app.js'])
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="copyright" content="{{ config('app.name') }}">
    <meta name="theme-color" content="#214154">
</head>
<body>
<div id="navbar">
    <div class="tube">
        <a class="logo" href="{{ config('app.url') }}"><img src="{{ config('app.url') }}/images/logo.svg"
                                                            alt="{{ config('app.name') }}" height="48" width="128"></a>
        <section><label for="main-nav" class="btn-menu inline-toggle"><i class="fa-solid fa-bars"></i> <span
                    class="sr-only">Menu</span></label><input
                type="checkbox" id="main-nav" class="inline-toggle">
            <nav id="main-menu" aria-label="main navigation">
                <a class="@if($current == config('app.url'))active @endif" href="/">Home</a>
                <a class="@if(Request::segment(1) == 'now') active @endif" href="/now">Now</a>
                <a class="@if(Request::segment(1) == 'posts') active @endif" href="{{ route('posts') }}">Posts</a>
                <a class="@if(Request::segment(1) == 'photos') active @endif" href="{{ route('photos') }}">Photos</a>
                <a class="@if(Request::segment(1) == 'collections') active @endif" href="{{ route('collections') }}">Collections</a>
                <a class="@if (Request::segment(1) == 'stream') active @endif"
                   href="{{ route('posts.stream') }}">Stream</a>
                <a class="@if (Request::segment(1) == 'projects') active @endif" href="/projects">Projects</a>
                @if (Auth::check())
                    <a href="{{ route('backend.index') }}" aria-label="backend"><i class="fa-solid fa-gear"
                                                                                   aria-hidden="true"></i></a>
                    <a href="{{ route('logout') }}" aria-label="Logout"><i class="fa-solid fa-arrow-right-from-bracket"
                                                                           aria-hidden="true"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                @endif
            </nav>
        </section>
    </div>
</div>
<div class="tube">
    <main class="site-main">
        @yield('content')
    </main>
</div>
<div id="pride-stripe"></div>
<footer class="site-footer">
                <small>&copy; Mark Sutherland {{ date('Y') }}. 🏳️‍🌈</small>
                <p>
                    <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/previous"
                       title="Webring Previous"
                       aria-label="Webring Previous"><i class="fa-solid fa-chevron-left"></i></a>
                    An IndieWeb Webring
                    <a href="https://xn--sr8hvo.ws/%F0%9F%93%BB%F0%9F%93%85%F0%9F%9A%BF/next" title="Webring Next"
                       aria-label="Webring Next"><i class="fa-solid fa-chevron-right"></i></a>
                </p>
                <nav id="footer-nav" aria-label="footer navigation">
                    <a href="/privacy">Privacy Policy</a>
                    <a href="/contact">Contact Me</a>
                </nav>
    <div class="lara-cat">
        <img src="/images/lara.webp" height="150" width="93" alt="Lara the cat"/>
    </div>
</footer>
@yield('extrascripts')
@env('staging')
    <script async defer src="https://scripts.withcabin.com/hello.js"></script>
@endenv
</body>
</html>
