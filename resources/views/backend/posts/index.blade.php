@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <h1>Posts</h1>
    <a href="{{ route('backend.posts.create') }}" class="btn">New Post</a>
    @livewire('backend-post-list')
@endsection
