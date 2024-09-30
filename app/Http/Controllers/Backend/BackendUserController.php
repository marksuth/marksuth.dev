<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BackendUserController extends Controller
{
    public function index(): View|Factory|Application
    {
        $users = User::latest()->orderBy('name')->paginate(20);

        return view('backend.users.index', compact('users'));
    }

    public function create(): View|Factory|Application
    {
        return view('backend.users.user');
    }

    /**
     * @throws ValidationException
     */
    public function store(): Application|Redirector|RedirectResponse
    {

        Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ])->validate();

        $user = new User;

        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');

        $user->save();

        return redirect('/backend/users');
    }

    public function edit($id): View|Factory|Application
    {
        $user = User::find($id);

        return view('backend.users.user', compact('user'));
    }

    /**
     * @throws ValidationException
     */
    public function update($id): Application|Redirector|RedirectResponse
    {

        Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ])->validate();

        $user = User::find($id);

        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');

        $user->save();

        return redirect('/backend/users');
    }

    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $user = User::find($id);

        $user->delete();

        return redirect('/backend/users');
    }

    public function show($id): View|Factory|Application
    {
        $user = User::find($id);

        return view('backend.users.user', compact('user'));
    }
}
