@extends('layouts.backend', [
    'title' => 'Pages',
    'description' => 'Manage your pages',
])

@section('content')
    <div class="header-actions">
        <h1>Pages</h1>
        <a href="{{ route('backend.pages.create') }}" class="btn btn-primary">Create New Page</a>
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
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->created_at->format('Y-m-d') }}</td>
                        <td class="actions">
                            <a href="{{ route('backend.pages.edit', $page) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('backend.pages.destroy', $page) }}" method="POST" style="display:inline">
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

    <div class="pagination-wrapper">
        {{ $pages->links() }}
    </div>
@endsection
