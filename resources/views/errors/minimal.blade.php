<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillNest - Online Learning Platform')</title>
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.skillnest.com/staticx/skillnest/images/v8/favicon-32x32.png" />
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

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Optimized reveal animation */
        [data-reveal] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        [data-reveal].revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    <x-frontend.offer-bar />
    <x-frontend.navbar />
    <x-frontend.category-bar />

    <main>
        {{-- Success Toast --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
                x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition transform ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
                class="fixed top-20 right-4 z-[9999] bg-white shadow-2xl rounded-lg overflow-hidden border border-gray-200 max-w-md">

                <div class="flex items-center p-4 gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Error Toast --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
                x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition transform ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
                class="fixed top-20 right-4 z-[9999] bg-white shadow-2xl rounded-lg overflow-hidden border border-gray-200 max-w-md">

                <div class="flex items-center p-4 gap-3">
                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900 flex-1">{{ session('error') }}</p>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- ───────────── ERROR SECTION (Tailwind only) ───────────── --}}
        <section class="flex flex-col items-center justify-center min-h-[70vh] px-6 py-16 text-center bg-white">

            {{-- SVG Illustration --}}
            <div class="mb-8">
                <svg viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-56 h-auto mx-auto">
                    <!-- Book stack -->
                    <rect x="40" y="130" width="160" height="22" rx="4" fill="#d1d7dc" />
                    <rect x="52" y="110" width="136" height="22" rx="4" fill="#b4c0c8" />
                    <rect x="64" y="90" width="112" height="22" rx="4" fill="#5624d0" opacity=".18" />
                    <!-- Sad face circle -->
                    <circle cx="120" cy="60" r="44" fill="#f7f9fa" stroke="#5624d0" stroke-width="3" />
                    <!-- Eyes -->
                    <circle cx="107" cy="52" r="4" fill="#5624d0" />
                    <circle cx="133" cy="52" r="4" fill="#5624d0" />
                    <!-- Sad mouth -->
                    <path d="M108 72 Q120 62 132 72" stroke="#5624d0" stroke-width="3" stroke-linecap="round"
                        fill="none" />
                    <!-- Eyebrow concern marks -->
                    <path d="M103 44 Q107 40 111 44" stroke="#5624d0" stroke-width="2.5" stroke-linecap="round"
                        fill="none" />
                    <path d="M129 44 Q133 40 137 44" stroke="#5624d0" stroke-width="2.5" stroke-linecap="round"
                        fill="none" />
                    <!-- Stars/sparkles -->
                    <path d="M24 30 L26 24 L28 30 L34 32 L28 34 L26 40 L24 34 L18 32 Z" fill="#f4831f"
                        opacity=".7" />
                    <path d="M196 24 L197.5 20 L199 24 L203 25.5 L199 27 L197.5 31 L196 27 L192 25.5 Z" fill="#5624d0"
                        opacity=".5" />
                </svg>
            </div>

            {{-- Error Code --}}
            <p class="text-8xl font-extrabold text-[#a435f0] leading-none tracking-tight mb-2 font-sora">
                @yield('code')
            </p>

            {{-- Orange Divider --}}
            <div class="w-14 h-1 bg-[#f4831f] rounded-full mx-auto my-4"></div>

            {{-- Error Title --}}
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 capitalize mb-3 font-sora">
                @yield('message')
            </h1>

            {{-- Sub-message --}}
            <p class="text-base text-gray-500 max-w-md leading-relaxed mb-8">
                Oops! Looks like this page took a wrong turn somewhere.<br>
                Don't worry — your learning journey isn't over yet.
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="/"
                    class="inline-block px-6 py-3 border-2 border-purple-700 bg-purple-600 hover:bg-purple-700  text-white text-sm font-bold rounded transition-colors duration-150">
                    Go to Homepage
                </a>
                <a href="javascript:history.back()"
                    class="inline-block px-6 py-3 border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 text-sm font-bold rounded transition-colors duration-150">
                    Go Back
                </a>
            </div>

        </section>
        {{-- ─────────────────────────────────────────────────────────── --}}

    </main>

    <x-frontend.footer />

    @stack('scripts')

    <script>
        // OPTIMIZED REVEAL ANIMATION - FASTER & SMOOTHER
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Small stagger only for items in same container
                    const container = entry.target.closest('[data-reveal-container]');
                    const siblings = container ? Array.from(container.querySelectorAll('[data-reveal]')) : [
                        entry.target
                    ];
                    const itemIndex = siblings.indexOf(entry.target);

                    // Much smaller delay - max 30ms per item (instead of 50ms)
                    setTimeout(() => {
                        entry.target.classList.add('revealed');
                    }, itemIndex * 30);

                    // Stop observing once revealed
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15, // Trigger earlier (was 0.1)
            rootMargin: '0px 0px -50px 0px' // Start animation 50px before element is visible
        });

        // Observe all elements
        document.querySelectorAll('[data-reveal]').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>
