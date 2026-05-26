<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillNest - Online Learning Platform')</title>
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

        @yield('content')
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
