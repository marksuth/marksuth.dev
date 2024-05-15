@extends('layouts.default',
[
    'title' => $collection->name,
    'description' => $collection->name . ' collection by Mark Sutherland, a developer and digital creative based in Leicester, UK',
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>{{ $collection->name }} Collection</h1>
        </div>
        @if($collection->description != '')
            <p class="page-tagline">{{ $collection->description }}</p>
        @endif
    </header>
    @include('collections.partials.'.$collection->slug)
@endsection
