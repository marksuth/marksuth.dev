@extends('layouts.default',
[
    'title' => 'Photo Stream',
    'description' => 'A stream of photos taken by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('title', 'Photo Stream')
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>Photo Stream</h1><a href="https://marksuth.dev/feed/photos.xml" title="Photos feed"><i class="fa-solid fa-rss-square"></i></a>
        </div>
    </header>
    @include('photos.photo-loop')
@endsection
