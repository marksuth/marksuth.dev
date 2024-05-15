@extends('layouts.backend', [
    'title' => 'Notepad',
])
@section('content')
    <h1>Notepad</h1>
    <a href="{{ route('backend.notes.create') }}" class="btn">New Note</a>
    <table>
        <thead>
        <tr>
            <th scope="col">Note</th>
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
                <td>
                    <form action="{{ route('backend.notes.destroy', $note->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">DELETE</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No notes found.</td>
            </tr>
        @endforelse
    </table>
@endsection
