@extends('layouts.simple', [
    'title' => 'Reset Password',
    'description' => 'Reset your password for ' . config('app.name'),
])

@section('content')
    <div class="auth-container">
        <h1 class="fancy-title">Reset Password</h1>

        <form method="POST" action="{{ route('password.update') }}" class="auth-form tile">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
            </div>

            <button type="submit" class="btn">
                Reset Password
            </button>
        </form>
    </div>
@endsection
