@extends('layouts.default',
[
    'title' => 'Photos from '. date('F Y', mktime(0, 0, 0, $month, 1, $year)),
    'description' => 'Photos from '. date('F Y', mktime(0, 0, 0, $month, 1, $year)) . ' taken by Mark Sutherland, a Web Developer based in Leicester, UK.'
])
@section('content')
    <header class="page-header">
        <div class="page-title">
            <h1>Photos From {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</h1>
        </div>
    </header>
    @include('photos.photo-loop')
@endsection
