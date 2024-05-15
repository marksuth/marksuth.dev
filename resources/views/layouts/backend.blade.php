<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="copyright" content="Mark Sutherland">
    <meta name="theme-color" content="#214154">
    <link rel="icon" href="{{ config('app.url') }}/images/icon.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png">

    <link rel="manifest" href="{{ config('app.url') }}/backend.webmanifest">

    @yield('metatags')

    @vite(['resources/sass/backend.scss', 'resources/js/backend.js'])
    @yield('extrastyles')

</head>
<body>
<nav id="navbar" aria-label="main-navigation">
    <div class="tube">
        <a class="logo" href="{{ route('backend.index') }}" rel="author">{{ config('app.name') }}</a>
        <section><label for="main-nav" class="btn-menu inline-toggle"><i class="fa-solid fa-bars"></i></label><input
                type="checkbox" id="main-nav" class="inline-toggle">
            <nav>
                <a href="{{ route('backend.posts') }}" title="Posts">Posts</a>
                <a href="{{ route('backend.types') }}" title="Stream">Types</a>
                <a href="{{ route('backend.collections') }}" title="Projects">Collections</a>
                <a href="{{ route('backend.notes') }}" title="Notes">Notes</a>
                <a href="{{ route('backend.photos') }}" title="Photos">Photos</a>
                <a href="{{ route('backend.pages') }}" title="Pages">Pages</a>
                <a href="/" target="_blank"><i class="fa-solid fa-globe"></i></a>
                <a class="nav-link" href="{{ route('logout') }}" title="Logout"><i
                        class="fa-solid fa-arrow-right-from-bracket"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
            </nav>
        </section>
    </div>
</nav>
<main id="primary" class="site-main">
    <div class="tube">
        @yield('content')
    </div>
</main>
<footer class="site-footer">
    <small>&copy; Mark Sutherland {{ date('Y') }}.</small>
</footer>
@yield('extrascripts')
</body>
</html>
