<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class BackendUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->orderBy('name')->paginate(20);

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.user');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User;

        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');

        $user->save();

        return redirect('/backend/users');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('backend.users.user', compact('user'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::find($id);

        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');

        $user->save();

        return redirect('/backend/users');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect('/backend/users');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('backend.users.user', compact('user'));
    }
}
