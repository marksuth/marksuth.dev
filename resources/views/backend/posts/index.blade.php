@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')

    <div class="row justify-content-between mb-4">
        <div class="col-6">
            <h1>Posts</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('backend.posts.create') }}" class="btn btn-primary">New Post</a>
        </div>
    </div>

    @livewire('backend-post-list')
@endsection
