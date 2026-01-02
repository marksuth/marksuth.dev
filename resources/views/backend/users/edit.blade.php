@extends('layouts.backend', [
    'title' => 'Edit User',
    'description' => 'Edit user details',
])

@section('content')
    <div class="header">
        <h1>Edit User: {{ $user->name }}</h1>
        <a href="{{ route('backend.users.index') }}" class="btn">Back to List</a>
    </div>

    <form action="{{ route('backend.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <button type="submit">Update User</button>
    </form>
@endsection
