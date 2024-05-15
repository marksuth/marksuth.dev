@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1>Post Collections</h1>
        <div>
            <a href="{{ route('backend.collections.create') }}" class="btn btn-primary">New Collection</a>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col" class="text-end">Status</th>
            <th class="col-2 text-end" scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($collections as $collection)
            <tr>
                <td><a href="{{ route('backend.collections.edit', $collection->id) }}">{{ $collection->name }}</a></td>
                <td class="small text-end">@if($collection->meta['published'] == 1)
                        Published
                    @else
                        Draft
                    @endif</td>
                <td class="text-end small">
                    <nav class="text-end">
                        <a href="/collections/{{ $collection->slug }}" class="btn btn-outline-primary btn-sm" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('backend.collections.edit', $collection->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-pen"></i></a>
                        <a href="{{ route('backend.collections.destroy', $collection->id) }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                    </nav>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No post collections found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
