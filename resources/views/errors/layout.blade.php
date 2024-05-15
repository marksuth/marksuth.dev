@extends('layouts.default'
, ['title' => $code . ' Error',
'description' => 'HTTP Error ' . $code . ' - ' . $message,
])
@section('metatags')
    <meta name="robots" content="noindex, nofollow"/>
@endsection
@section('content')
    <section id="error-page">
        <h1>Ahh @if($exception->getStatusCode() == 418)
                🫖, I'm a teapot.
            @else
                💩, it's a {{ $code }}.
            @endif</h1>
        <p>HTTP ERROR {{ $code }}</p>
        <p>{{ $message }}</p>
        <p>If you believe you’ve reached this page in error, please drop me an email.</p>
        <br><a href="{{ config('app.url') }}" class="btn btn-dark">Return Home <i class="fa-solid fa-house"></i></a>
    </section>
    <div class="error-cat">
        <img src="/images/lara.webp" height="120" width="88" alt="Lara the cat"/>
    </div>
@endsection

@section('extrascripts')
    <script>
        const pattern = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
        let current = 0;
        const audio = new Audio('/images/thats_so_mark.mp3');
        const keyHandler = function (event) {
            if (pattern.indexOf(event.key) < 0 || event.key !== pattern[current]) {
                current = 0;
                return;
            }
            current++;
            if (pattern.length === current) {
                current = 0;
                audio.play();
            }
        };
        document.addEventListener('keydown', keyHandler, false);
    </script>
@endsection
