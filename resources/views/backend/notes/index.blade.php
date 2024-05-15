@extends('layouts.backend', [
    'title' => 'Notepad',
])
@section('content')

    <div class="row justify-content-between mb-4">
        <div class="col-6">
            <h1>Notepad</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('backend.notes.create') }}" class="btn btn-primary">New Note</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" class="col-10">Note</th>
                <th scope="col" class="col text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($notes as $note)
                <tr>
                    <td>
                        <a href="{{ route('backend.notes.edit', $note->id) }}">{{ $note->title }}</a><br>
                        <small>Last updated: {{ $note->updated_at->format('jS F Y') }}</small>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('backend.notes.destroy', $note->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">DELETE</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No notes found.</td>
                </tr>
            @endforelse
        </table>
    </div>

@endsection
