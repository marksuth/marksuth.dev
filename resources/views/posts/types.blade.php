@extends('layouts.default',
[
    'title' => 'Post Types',
    'description' => 'An overview of post types on Mark Sutherland\'s blog.',
])
@section('content')
    <header class="page-header">
        <h1 class="page-title">Post Type Overview</h1>
    </header>
    <ul class="tile-grid tile-grid-sm">
        @forelse($types as $type)
            @if($type->count > 0)
                <li>
                <a href="/posts/type/{{ strtolower($type->name) }}" class="title tile-dark">

                    @if($type->count > 1)
                        {{ Str::of($type->name)->plural() }}
                    @else
                        {{ $type->name }}
                    @endif
                    <small class="small">({{ $type->count }})</small>
                </a>
                </li>
            @endif
        @empty
                <li>No post types found</li>
        @endforelse
    </ul>
@endsection
