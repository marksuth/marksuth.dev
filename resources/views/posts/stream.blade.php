@extends('layouts.default',
[
    'title' => 'Activity Stream',
    'description' => 'Activity stream of Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
<header class="page-header">
    <div class="page-title">
    <h1>Activity Stream</h1> <a href="https://marksuth.dev/feed/stream.xml" title="Stream feed"><i class="fa-solid fa-rss-square"></i></a>
    </div>
    <p class="page-tagline">A stream of everything that's not a note or article.</p>
</header>
@include('posts.post-loop')
@endsection
