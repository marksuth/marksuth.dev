@extends('layouts.default',
 ['title' => 'Posts',
'description' => 'A list of all posts by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1 class="p-name">Previous Posts</h1> <a href="{{ config('app.url') }}/feed/posts.xml"
                                                      title="Posts feed"><i class="fa-solid fa-rss-square"></i></a>
        </div>
    </header>
    @include('posts.post-loop')
@endsection
