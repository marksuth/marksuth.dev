@extends('layouts.backend', [
    'title' => 'Backend',
])
@section('content')
    <div class="split">
        <h1>Post Collections</h1>
            <a href="{{ route('backend.collections.create') }}" class="btn">New Collection</a>
    </div>
    <table>
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($collections as $collection)
            <tr>
                <td><a href="{{ route('backend.collections.edit', $collection->id) }}">{{ $collection->name }}</a></td>
                <td>@if($collection->meta['published'] == 1)
                        Published
                    @else
                        Draft
                    @endif</td>
                <td>
                    <nav>
                        <a href="/collections/{{ $collection->slug }}" class="btn" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('backend.collections.edit', $collection->id) }}" class="btn"><i class="fa-solid fa-pen"></i></a>
                        <a href="{{ route('backend.collections.destroy', $collection->id) }}" class="btn"><i class="fa-solid fa-trash"></i></a>
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
