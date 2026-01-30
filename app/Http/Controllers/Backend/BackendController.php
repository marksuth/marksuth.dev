<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class BackendController extends Controller
{
    /**
     * Show the backend dashboard.
     */
    public function index(): View
    {
        return view('backend.index', [
            'stats' => [
                'pages' => Page::count(),
                'posts' => Post::count(),
                'photos' => Photo::count(),
                'users' => User::count(),
            ],
        ]);
    }

    /**
     * Display a listing of the users.
     */
    public function users(): View
    {
        return view('backend.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function createUser(): View
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('backend.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function showUser(User $user): View
    {
        return view('backend.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user): View
    {
        return view('backend.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('backend.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('backend.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Create a Webmanifest file for PWA support.
     */
    public function webmanifest()
    {
        return response()->view('backend.webmanifest')->header('Content-Type', 'application/manifest+json');
    }
}
