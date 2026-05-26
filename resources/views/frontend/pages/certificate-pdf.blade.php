<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillNest - Certificate')</title>
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.skillnest.com/staticx/skillnest/images/v8/favicon-32x32.png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="bg-gray-50 py-8 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-8">

                {{-- Certificate Display --}}
                <div id="certificate" class="relative bg-white p-8 sm:p-12 md:p-16" style="aspect-ratio: 1.414/1;">

                    {{-- Decorative Border --}}

                    <div class="absolute inset-6 border-2 border-purple-300 rounded-lg"></div>

                    {{-- Certificate Content --}}
                    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center">

                        {{-- Logo/Badge --}}
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center mb-6 sm:mb-8">
                            <i class="fas fa-certificate text-white text-2xl sm:text-3xl"></i>
                        </div>

                        {{-- Title --}}
                        <h1 class="font-serif text-xl sm:text-2xl md:text-3xl text-gray-800 mb-3 sm:mb-4">
                            Certificate of Completion
                        </h1>

                        {{-- Subtitle --}}
                        <p class="text-xs sm:text-sm text-gray-600 mb-6 sm:mb-8">This certifies that</p>

                        {{-- Student Name --}}
                        <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-purple-600 mb-6 sm:mb-8">
                            {{ $user->name }}
                        </h2>

                        {{-- Description --}}
                        <p class="text-xs sm:text-sm text-gray-600 mb-2">has successfully completed the course</p>

                        {{-- Course Title --}}
                        <h3 class="font-bold text-base sm:text-lg md:text-xl text-gray-900 mb-6 sm:mb-8 max-w-lg px-4">
                            {{ $course->title }}
                        </h3>

                        {{-- Course Duration --}}
                        <p class="text-xs sm:text-sm text-gray-600 mb-8 sm:mb-12">
                            Course Duration: {{ $course->duration ?? 'N/A' }} hours
                        </p>

                        {{-- Footer Info --}}
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between w-full max-w-lg gap-4 sm:gap-8 mt-auto">
                            <div class="text-center sm:text-left">
                                <div class="border-t-2 border-gray-800 pt-2 mb-1">
                                    <p class="text-xs sm:text-sm font-bold text-gray-900">
                                        {{ $course->instructor->name }}
                                    </p>
                                </div>
                                <p class="text-xs text-gray-600">Instructor</p>
                            </div>

                            <div class="text-center sm:text-right">
                                <div class="border-t-2 border-gray-800 pt-2 mb-1">
                                    <p class="text-xs sm:text-sm font-bold text-gray-900">
                                        {{ $completedAt ? $completedAt->format('d M, Y') : now()->format('d M, Y') }}
                                    </p>
                                </div>
                                <p class="text-xs text-gray-600">Date of Completion</p>
                            </div>
                        </div>

                        {{-- SkillNest Logo/Text --}}
                        <div class="mt-8">
                            <p class="text-purple-600 font-bold text-sm sm:text-base">SkillNest</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
