<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'username' => Str::slug($request->name) . rand(100,999),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login
        Auth::login($user);

        // Redirect ke dashboard member
        return redirect()->route('member.dashboard');
    }
}
