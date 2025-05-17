<?php

use App\Models\User;

test('user model can be instantiated', function () {
    $user = new User;
    expect($user)->toBeInstanceOf(User::class);
});

test('user model has correct casts', function () {
    $user = new User;
    $casts = $user->getCasts();

    expect($casts)
        ->toHaveKey('email_verified_at', 'datetime')
        ->toHaveKey('password', 'hashed');
});

test('user model has correct fillable attributes', function () {
    $user = new User;
    expect($user->getFillable())
        ->toContain('name')
        ->toContain('email')
        ->toContain('password');
});

test('user model has correct hidden attributes', function () {
    $user = new User;
    expect($user->getHidden())
        ->toContain('password')
        ->toContain('remember_token');
});
