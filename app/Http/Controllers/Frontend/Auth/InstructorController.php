<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Spatie\Permission\Models\Role;

class InstructorController extends Controller
{
    public function instructorLogin()
    {
        return view('frontend.pages.auth.teach-login');
    }

    public function store(Request $request)
    {

        if (auth()->user() && auth()->user()->hasAnyRole([1, 3])) {
            auth()->user()->assignRole(2);

            return to_route('instructor.dashboard');
        }

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (! $user->hasRole('instructor')) {
                $user->assignRole('instructor');
            }

            return to_route('instructor.dashboard');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }
}
