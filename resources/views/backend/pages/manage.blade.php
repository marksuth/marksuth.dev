@extends('layouts.backend',
[
    'title' => 'Page Editor',
    'description' => '',
])
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        @livewire('page-editor', ['page' => $page ?? null])
    </div>
@endsection
