<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('tamus.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil admin berdasarkan username
        $admin = Admin::where('username', $request->username)->first();

        // Username tidak ditemukan
        if (!$admin) {
            return back()->with('error', 'Akun tidak ditemukan.')->withInput();
        }

        // Password salah
        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Password salah.')->withInput();
        }

        // Login guard admin
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        return redirect()->route('tamus.index');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
