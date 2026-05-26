<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('frontend.pages.auth.login');
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return to_route('index');
        } else {

            return back();
        }
    }

    public function signup()
    {
        return view('frontend.pages.auth.signup');
    }
}
