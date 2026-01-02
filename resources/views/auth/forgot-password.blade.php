@extends('layouts.simple', [
    'title' => 'Forgot Password',
    'description' => 'Request a password reset link for ' . config('app.name'),
])

@section('content')
    <div class="auth-container">
        <h1 class="fancy-title">Forgot Password</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form tile">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">
                Send Password Reset Link
            </button>

            <div class="form-actions">
                <a href="{{ route('login') }}" class="forgot-link">
                    Back to login
                </a>
            </div>
        </form>
    </div>
@endsection
