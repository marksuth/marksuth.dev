@extends('layouts.simple', [
    'title' => 'Login',
    'description' => 'Login to the backend of ' . config('app.name'),
])

@section('content')
    <div class="auth-container">
        <h1 class="fancy-title">Login</h1>

        <form method="POST" action="{{ route('login') }}" class="auth-form tile">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="form-label">Remember Me</label>
            </div>

                <button type="submit" class="btn">
                    Login
                </button>


                @if (Route::has('password.request'))
                    <br>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Forgot password?
                    </a>
                @endif
        </form>
    </div>
@endsection
