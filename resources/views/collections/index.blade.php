@extends('layouts.default',
[
    'title' => 'Collections',
    'description' => 'An overview of various curated collections on Mark Sutherland\'s blog.',
])
@section('content')
    <header class="page-header py-5">
        <h1 class="page-name">Collections of Things</h1>
    </header>
    <ul class="tile-grid tile-grid-lg">
        @forelse($collections as $collection)
            <li class="tile">
                <a class="collection-cover" style="background-image: url('/storage/{{ $collection->meta['img_url'] }}');" href="/collections/{{ strtolower($collection->slug) }}">{{ $collection->name }}</a>
            </li>
        @empty
            <li>No collections found.</li>
        @endforelse
    </ul>
@endsection
