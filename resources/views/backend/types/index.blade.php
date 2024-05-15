@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1>Posts</h1>
        <div>
            <a href="{{ route('backend.types.create') }}" class="btn btn-primary">New Post Type</a>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col" class="text-end">Status</th>
            <th></th>
            <th class="col-1 text-end" scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($types as $type)
            <tr>
                <td><a href="{{ route('backend.types.edit', $type->id) }}">{{ $type->name }}</a></td>
                <td class="small">Published</td>
                <td></td>
                <td class="text-end small"><a href="{{ route('backend.types.edit', $type->id) }}">Edit</a>
                    <a href="/types/{{ $type->slug }}" target="blank">View</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No post types found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
