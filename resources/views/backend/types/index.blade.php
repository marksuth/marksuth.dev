@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
        <h1>Posts</h1>
            <a href="{{ route('backend.types.create') }}" class="btn btn-primary">New Post Type</a>
    <table>
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th></th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($types as $type)
            <tr>
                <td><a href="{{ route('backend.types.edit', $type->id) }}">{{ $type->name }}</a></td>
                <td>Published</td>
                <td></td>
                <td><a href="{{ route('backend.types.edit', $type->id) }}">Edit</a>
                    <a href="/types/{{ $type->slug }}" target="blank">View</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No post types found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
