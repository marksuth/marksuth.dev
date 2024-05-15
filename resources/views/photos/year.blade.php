@extends('layouts.default',
[
    'title' => 'Photos from '. $year,
    'description' => 'Photos from '. $year . ' taken by Mark Sutherland, a Web Developer based in Leicester, UK.'
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>Photos From {{ $year }}</h1>
        </div>
    </header>
    @include('photos.photo-loop')
@endsection
