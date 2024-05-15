@extends('layouts.simple', [
    'title' => 'Login',
    'description' => 'Login to your account',
     ]
     )
@section('content')
        <div id="login-box">
            <form method="POST" action="{{ route('login') }}" class="tile">
                @csrf
                <h1>Login</h1>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
                @endif
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" aria-describedby="emailHelp">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <button type="submit" class="btn">Login</button>
            </form>
            <small><a href="{{ route('password.request') }}">Forgot your password?</a></small>
        </div>
@endsection
