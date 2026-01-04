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
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:description" content="{{ $description }}">
    <link rel="author" href="{{ config('app.url') }}">
    <link rel="icon" type="image/png" href="{{ config('app.url') }}/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="{{ config('app.url') }}/favicon.svg"/>
    <link rel="shortcut icon" href="{{ config('app.url') }}/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png"/>
    <link rel="manifest" href="{{ route('backend.webmanifest') }}">
    @vite(['resources/sass/backend.scss', 'resources/js/backend.js'])
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
                <a class="@if(Request::segment(2) == 'posts') active @endif" href="{{ route('backend.posts.index') }}">Posts</a>
                <a class="@if(Request::segment(2) == 'photos') active @endif" href="{{ route('backend.photos.index') }}">Photos</a>
                <a class="@if(Request::segment(2) == 'pages') active @endif" href="{{ route('backend.pages.index') }}">Pages</a>
                <a class="@if(Request::segment(2) == 'collections') active @endif" href="{{ route('backend.collections.index') }}">Collections</a>
                <a class="@if(Request::segment(2) == 'users') active @endif" href="{{ route('backend.users.index') }}">Users</a>
                <a href="{{ config('app.url') }}"><i class="fa-solid fa-globe"></i></a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-sign-out"></i></a>

            </nav>
        </section>
    </div>
</div>
<div class="tube">
    <main class="site-main">
        @yield('content')
    </main>
</div>
<footer class="site-footer tube">
    <div class="footer-text">
        <small>&copy; Mark Sutherland {{ date('Y') }}. 🏳️‍🌈</small>
    </div>
</footer>
@yield('extrascripts')
</body>
</html>
