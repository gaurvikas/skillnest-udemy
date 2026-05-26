<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Instructor Dashboard - SkillNest')</title>
    <link rel="icon" sizes="32x32" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .font-sora,
        h1,
        h2,
        h3 {
            font-family: 'Sora', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false }">

    {{-- Top Navigation --}}
    <nav class="bg-gray-900 text-white h-14 sm:h-16 fixed top-0 left-0 right-0 z-50">
        <div class="h-full px-4 sm:px-6 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-6 lg:gap-8">
                {{-- Mobile Menu Button --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 hover:bg-gray-800 rounded transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <a href="{{ route('index') }}" class="font-bold text-xl sm:text-2xl text-purple-400">
                    <img src="{{ asset('logo-dark.png') }}" alt="SkillNest" class="h-12" />
                </a>
                <span class="hidden sm:block text-xs sm:text-sm text-gray-400">Instructor</span>
            </div>

            <div class="flex items-center gap-3 sm:gap-6">
                <a href="{{ route('index') }}"
                    class="hidden sm:flex items-center gap-2 text-sm hover:text-purple-400 transition">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Student</span>
                </a>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 hover:text-purple-400 transition">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                            {{ auth()->user()->initials() }}
                        </div>
                        <i class="fas fa-chevron-down text-xs hidden sm:block"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-full mt-2 w-56 sm:w-64 bg-white text-gray-900 rounded-lg shadow-xl border border-gray-200 py-2">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="font-semibold text-sm sm:text-base truncate">{{ auth()->user()->name ?? 'User' }}
                            </p>
                            <p class="text-xs sm:text-sm text-gray-600 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">
                            <i class="fas fa-user w-5"></i> My Profile
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50">
                            <i class="fas fa-cog w-5"></i> Settings
                        </a>
                        <hr class="my-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt w-5"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-14 sm:pt-16">

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside
            class="w-64 bg-white border-r border-gray-200 fixed left-0 top-14 sm:top-16 bottom-0 overflow-y-auto z-40 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <nav class="p-3 sm:p-4">
                <a href="{{ route('instructor.dashboard') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                          {{ request()->routeIs('instructor.dashboard') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-chart-line w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Dashboard</span>
                </a>

                <a href="{{ route('instructor.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                          {{ request()->routeIs('instructor.index*') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-graduation-cap w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Courses</span>
                </a>

                <a href="{{ route('discussion.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                          {{ request()->routeIs('discussion.index*') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-comments w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Discussions</span>
                    <span
                        class="ml-auto px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">{{ $unansweredDiscussions }}</span>
                </a>

                <a href="{{ route('instructor.stripe.dashboard') }}" @click="sidebarOpen = false" target="_blank"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                        {{ request()->routeIs('instructor.stripe*') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-wallet w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Earnings</span>
                    @if (auth()->user()->instructorStripeAccount?->payouts_enabled)
                        <span class="ml-auto w-2 h-2 bg-green-500 rounded-full"></span>
                    @else
                        <span class="ml-auto w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    @endif
                </a>

                <a href="#" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                          {{ request()->routeIs('instructor.performance*') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-chart-bar w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Performance</span>
                </a>

                <a href="#" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-100 transition mb-1
                          {{ request()->routeIs('instructor.tools*') ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-tools w-5 text-base"></i>
                    <span class="text-sm sm:text-base">Tools</span>
                </a>

            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 lg:ml-64 min-h-screen">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

</body>

</html>
