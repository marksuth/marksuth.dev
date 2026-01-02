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
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:image" content="{{ config('app.url') }}/images/@yield('ogimg', 'opengraph.jpg')">
    <meta property="og:image:secure_url" content="{{ config('app.url') }}/images/@yield('ogimg', 'opengraph.jpg')">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    @yield('metatags')
    <link rel="me" href="https://github.com/marksuth">
    <link rel="me" href="https://www.instagram.com/marksuth">
    <link rel="me" href="https://www.linkedin.com/in/marksuth">
    <link rel="me" href="https://medium.com/@marksuth">
    <link rel="me" href="https://letterboxd.com/marksuth">
    <link rel="author" href="{{ config('app.url') }}">
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
