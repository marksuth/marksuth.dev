@extends('layouts.backend', [
    'title' => 'Users',
    'description' => 'Manage users',
])

@section('content')
    <div class="header">
        <h1>Users</h1>
        <a href="{{ route('backend.users.create') }}" class="btn">Create User</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('backend.users.show', $user) }}">View</a>
                        <a href="{{ route('backend.users.edit', $user) }}">Edit</a>
                        <form action="{{ route('backend.users.destroy', $user) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
