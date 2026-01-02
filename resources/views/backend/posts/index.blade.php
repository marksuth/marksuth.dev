@extends('layouts.backend', [
    'title' => 'Posts',
    'description' => 'Manage your posts',
])

@section('content')
    <div class="header-actions">
        <h1>Posts</h1>
        <a href="{{ route('backend.posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->created_at->format('Y-m-d') }}</td>
                        <td class="actions">
                            <a href="{{ route('backend.posts.edit', $post) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('backend.posts.destroy', $post) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $posts->links() }}
@endsection
