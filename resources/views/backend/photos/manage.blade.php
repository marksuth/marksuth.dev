@extends('layouts.backend', [
    'title' => $title,
    'description' => '',
])
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        @livewire('photo-editor', ['photo' => $photo ?? null])
    </div>
@endsection
