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
    <link rel="icon" href="{{ config('app.url') }}/images/icon.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/icons/icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/icons/icon-16.png">

    <link rel="manifest" href="{{ route('backend.webmanifest') }}">

    @yield('metatags')

    @vite(['resources/sass/backend.scss', 'resources/js/backend.js'])
    @yield('extrastyles')

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary mb-4 sticky-top">
        <div class="container-fluid">
            <a href="{{ route('backend.index') }}" class="navbar-brand">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.posts') }}" title="Posts">Posts</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.types') }}" title="Stream">Types</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.collections') }}" title="Projects">Collections</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.notes') }}" title="Notes">Notes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.photos') }}" title="Photos">Photos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.pages') }}" title="Pages">Pages</a></li>
                <li class="nav-item"><a class="nav-link" href="/" target="_blank"><i class="fa-solid fa-globe"></i></a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" title="Logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                </li>

            </ul>
        </div>
        </div>
    </nav>
    <div class="container-xxl">
        <main id="primary" class="site-main">
            @yield('content')
        </main>
    </div>
    <footer class="text-center py-3 text-muted">
            <small>&copy; Mark Sutherland {{ date('Y') }}.</small>
    </footer>
    @yield('extrascripts')
</body>

</html>
