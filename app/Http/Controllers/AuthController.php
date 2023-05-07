<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // resource for login page
    public function create()
    {
        return inertia('Auth/Login');
    }

    // resource for attempting to create new user session
    public function store(Request $request)
    {
        // Check Authentication attempt
        if (!Auth::attempt($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]), true)) {
            // throw error if not authenticated
            throw ValidationException::withMessages([
                'email' => 'Authentication failed',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing');
    }

    // resource for destroying user session
    public function destroy()
    {

    }
}
