<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;

it('can see the login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Login');
});

it('can see the forgot password page', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
    $response->assertSee('Forgot Password');
});

it('can see the reset password page', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $response = $this->get("/reset-password/{$token}?email={$user->email}");

    $response->assertStatus(200);
    $response->assertSee('Reset Password');
});
