@extends('layouts.default',
[
    'title' => 'Posts Archive: ' . $type->name,
    'description' => $type->name . ' posts by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>{{ $type->name }} Posts</h1>
        </div>
        @if($type->description != '')
            <p class="page-tagline">{{ $type->description }}</p>
        @endif
    </header>
    @if($posts->count() == 0)
        <div class="mt-5 text-center pt-5">
            @if($type->slug == 'sign')
                <i class="fa-solid fa-signs-post fa-5x my-3"></i>
                <p>This is a sign of something. Not sure what though cos I've not written about it yet.</p>
            @elseif($type->slug == 'lamp')
                <i class="fa-solid fa-lightbulb fa-5x my-3"></i>
                <p>I love lamp. Not posted about it yet though.</p>
            @else
                <p>There aren't any {{ strtolower($type->name) }} posts in the distant past. That I can remember. Or
                    find.</p>
            @endif
        </div>
    @else
        @include('posts.post-loop')
    @endif
    @if($type->near_future == '1' || $type->distant_past == '1')
        <div class="d-flex justify-content-evenly mb-4">

            @if($type->distant_past == '1')
                <a href="/posts/type/{{ $type->slug }}/distant-past"
                   class="btn btn-outline-light btn-sm">View {{ strtolower($type->name) }} posts in the distant past</a>
            @endif
            @if($type->near_future == '1')
                <a href="/posts/type/{{ $type->slug }}/near-future"
                   class="btn btn-outline-light btn-sm">View {{ strtolower($type->name) }} posts in the near future</a>
            @endif
        </div>
    @endif
@endsection
