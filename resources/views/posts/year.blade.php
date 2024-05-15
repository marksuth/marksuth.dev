@extends('layouts.default',
[
    'title' => 'Posts from '. $year,
    'description' => 'Posts from '. $year . ' by Mark Sutherland, a Web Developer based in Leicester, UK.'
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>Posts from {{ $year }}</h1>
        </div>
    </header>
    @include('posts.post-loop')
@endsection
