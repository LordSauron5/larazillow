<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    // Resource for displaying the create user form
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    // save the user
    public function store(Request $request)
    {
        // make new user
        $user = User::create($request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required','string','min:8', 'confirmed'],
        ]));

        // authenticate the user
        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('listing.index')->with('success', 'Your account has been created');
    }
}
