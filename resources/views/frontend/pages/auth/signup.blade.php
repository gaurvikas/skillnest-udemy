{{-- resources/views/pages/register.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Sign Up - Udemy')
@section('content')

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl w-full max-w-md p-6 sm:p-10">

            <div class="text-center mb-8">
                <div class="flex justify-center mb-3">
                    <a href="{{ route('index')}}">
                        <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-12">
                    </a>
                </div>
                <h1 class="font-sora text-xl font-bold text-gray-900 mt-3">Create your account</h1>
                <p class="text-gray-400 text-sm mt-1">Join 57 million learners today</p>
            </div>

            <div class="space-y-3 mb-6">
                <a href="{{ route('auth.google') }}"
                    class="w-full flex items-center justify-center gap-3 border border-gray-200 rounded-xl py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    <img src="https://www.google.com/favicon.ico" class="w-4 h-4"> Continue with Google
                </a>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative text-center"><span class="bg-white px-4 text-xs text-gray-400">or</span></div>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">First Name</label>
                    <input type="text" name="name" placeholder="Rahul"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition placeholder-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">Email</label>
                    <input type="email" name="email" placeholder="you@example.com"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition placeholder-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition placeholder-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition placeholder-gray-300">
                </div>
                <label class="flex items-start gap-2.5 cursor-pointer">
                    <input type="checkbox" name="terms" class="accent-purple-600 w-4 h-4 mt-0.5 shrink-0">
                    <span class="text-xs text-gray-400 leading-relaxed">
                        I agree to the <a href="#" class="text-purple-600 underline">Terms</a> and
                        <a href="#" class="text-purple-600 underline">Privacy Policy</a>
                    </span>
                </label>
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 active:scale-[0.98] text-white font-bold py-3.5 rounded-xl text-sm transition-all">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Log in</a>
            </p>
        </div>
    </div>

@endsection
