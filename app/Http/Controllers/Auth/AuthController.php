<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.login');
    }



        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
                $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, $request->filled('remember'))){
                $request->session()->regenerate();
                if (Auth::user()->role === 'admin') {
                    return redirect()->intended('/admin/dashboard');
                }

                return redirect()->intended('/');
            }

            return back()->withErrors(['email' => 'Invalid login details']);
        }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
