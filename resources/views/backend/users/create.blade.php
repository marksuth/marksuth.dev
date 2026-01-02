@extends('layouts.backend', [
    'title' => 'Create User',
    'description' => 'Create a new user',
])

@section('content')
    <div class="header">
        <h1>Create User</h1>
        <a href="{{ route('backend.users.index') }}" class="btn">Back to List</a>
    </div>

    <form action="{{ route('backend.users.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit">Create User</button>
    </form>
@endsection
