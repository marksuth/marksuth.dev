<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title . ' - ' . config('app.name')}}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="copyright" content="{{ config('app.name') }}">
    <meta name="theme-color" content="#214154">
    @yield('metatags')

    <link rel="me" href="https://github.com/marksuth">
    <link rel="me" href="https://twitter.com/marksuth">
    <link rel="me" href="https://www.instagram.com/marksuth">
    <link rel="me" href="https://www.linkedin.com/in/marksuth">
    <link rel="me" href="https://medium.com/@marksuth">

    @vite(['resources/sass/style.scss', 'resources/js/app.js'])
    @yield('extrastyles')
</head>
<body>
<nav id="navbar" aria-label="main-navigation">
    <div class="tube">
        <a class="logo" href="{{ config('app.url') }}" rel="author">{{ config('app.name') }}</a>
    </div>
</nav>
<div class="tube site-main">
        @yield('content')
</div>
<footer class="site-footer">
    <small>&copy; Mark Sutherland {{ date('Y') }}. 🌈</small>
    <nav class="footer-nav">
        <a href="/privacy">Privacy Policy</a>
        <a href="/contact">Contact Me</a>
    </nav>
</footer>
@yield('extrascripts')
</body>
</html>
