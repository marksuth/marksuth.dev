@extends('layouts.backend', [
    'title' => 'User Details',
    'description' => 'View user details',
])

@section('content')
    <div class="header">
        <h1>User: {{ $user->name }}</h1>
        <a href="{{ route('backend.users.index') }}" class="btn">Back to List</a>
    </div>

    <div class="details">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="actions">
        <a href="{{ route('backend.users.edit', $user) }}" class="btn">Edit</a>
    </div>
@endsection
