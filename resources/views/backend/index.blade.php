@extends('layouts.backend',
[
    'title' => 'Backend',
    'description' => '',
])
@section('content')
    <h1>Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><a href="{{ route('backend.pages.index') }}">Pages</a></h3>
            <p>{{ $stats['pages'] }}</p>
        </div>
        <div class="stat-card">
            <h3><a href="{{ route('backend.posts.index') }}">Posts</a></h3>
            <p>{{ $stats['posts'] }}</p>
        </div>
        <div class="stat-card">
            <h3><a href="{{ route('backend.photos.index') }}">Photos</a></h3>
            <p>{{ $stats['photos'] }}</p>
        </div>
        <div class="stat-card">
            <h3><a href="{{ route('backend.users.index') }}">Users</a></h3>
            <p>{{ $stats['users'] }}</p>
        </div>
    </div>
@endsection
