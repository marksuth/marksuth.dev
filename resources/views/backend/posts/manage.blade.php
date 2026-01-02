@extends('layouts.backend',
[
    'title' => 'Post Editor',
    'description' => '',
])
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        @livewire('post-editor', ['post' => $post ?? null])
    </div>
@endsection
