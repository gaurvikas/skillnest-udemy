{{-- resources/views/frontend/pages/instructor/auth/login.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Instructor Login - Udemy')
@section('content')

    <div
        class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 flex items-center justify-center py-12 px-4">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-10">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('logo-light.png') }}" alt="Udemy" class="h-12">
                    </a>
                </div>

                {{-- Instructor Badge --}}
                <div class="inline-flex items-center gap-2 bg-purple-50 text-purple-700 px-4 py-2 rounded-full mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                    </svg>
                    <span class="text-sm font-bold">Instructor Portal</span>
                </div>

                <h1 class="font-sora text-2xl font-bold text-gray-900 mt-3">Welcome back, Instructor!</h1>
                <p class="text-gray-500 text-sm mt-1.5">Log in to access your teaching dashboard</p>
            </div>

            {{-- SOCIAL LOGIN --}}
            <div class="space-y-3 mb-6">
                <a href="{{ route('auth.google') }}"
                    class="w-full flex items-center justify-center gap-3 border-2 border-gray-200 rounded-xl py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-purple-300 transition-all">
                    <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                    Continue with Google
                </a>
            </div>

            {{-- DIVIDER --}}
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative text-center">
                    <span class="bg-white px-4 text-xs font-medium text-gray-400">or login with email</span>
                </div>
            </div>

            {{-- LOGIN FORM --}}
            <form action="#" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="instructor@skillnest.com"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition placeholder-gray-300 @error('email') border-red-300 @enderror">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full border-2 border-gray-200 rounded-xl pl-12 pr-12 py-3.5 text-sm outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition placeholder-gray-300 @error('password') border-red-300 @enderror">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-purple-600 rounded">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700 hover:underline">
                        Forgot password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 active:scale-[0.98] text-white font-bold py-4 rounded-xl text-sm transition-all shadow-lg shadow-purple-500/30">
                    Log In to Teaching Dashboard
                </button>
            </form>

            {{-- INFO BOX --}}
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-900 mb-1">Instructor Account Required</p>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            This portal is for Udemy instructors only. If you're a student, please use the
                            <a href="{{ route('login') }}" class="underline font-semibold">student login page</a>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- FOOTER LINKS --}}
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-center text-sm text-gray-500 mb-3">
                    Not teaching on Udemy yet?
                </p>
                <form action="{{ route('instructor.login.store') }}" method="post">
                    @csrf
                    <button type="submit"
                        class="block w-full text-center border-2 border-purple-600 text-purple-600 font-bold py-3 rounded-xl text-sm hover:bg-purple-50 transition-all">
                        Become an Instructor
                    </button>
                </form>
                <p class="text-center text-xs text-gray-400 mt-4">
                    By logging in, you agree to our
                    <a href="#" class="text-purple-600 underline">Terms of Use</a> and
                    <a href="#" class="text-purple-600 underline">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    {{-- Toggle Password Script --}}
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>

@endsection
