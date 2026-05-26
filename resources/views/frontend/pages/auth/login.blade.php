{{-- resources/views/pages/login.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Log In - SkillNest')
@section('content')

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl w-full max-w-md p-6 sm:p-10">
            {{-- <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-34"> --}}
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-12">
                    </a>
                </div>
                <p class="text-gray-400 text-sm">Log in to continue learning</p>
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

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">Email</label>
                    <input type="email" name="email" placeholder="you@example.com"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition placeholder-gray-300">
                </div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" id="pw-field"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition pr-12 placeholder-gray-300">
                        <button type="button" onclick="togglePw()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-600 transition">
                            <i class="fa fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="status">{{ $message }}</div>
                    @enderror
                    <div class="text-right mt-1">
                        <a href="{{ url('/forgot-password') }}" class="text-xs text-purple-600 hover:underline">Forgot
                            password?</a>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 active:scale-[0.98] text-white font-bold py-3.5 rounded-xl text-sm transition-all">
                    Log In
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">Sign up free</a>
            </p>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function togglePw() {
            const f = document.getElementById('pw-field');
            const i = document.getElementById('pw-icon');
            f.type = f.type === 'password' ? 'text' : 'password';
            i.className = f.type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
        }
    </script>
@endpush
