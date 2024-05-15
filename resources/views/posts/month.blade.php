@extends('layouts.default',
[
    'title' => 'Posts from ' . date("F Y", mktime(0, 0, 0, $month, 1, $year)),
    'description' => 'A list of all posts from ' . date("F Y", mktime(0, 0, 0, $month, 1, $year)) . ' by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>Posts from {{ date("F Y", mktime(0, 0, 0, $month, 1, $year)) }}</h1>
        </div>
</header>
@include('posts.post-loop')
@endsection
