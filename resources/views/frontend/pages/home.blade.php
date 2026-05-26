{{-- resources/views/pages/home.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'SkillNest - Learn Anything, Anywhere')

@section('content')

    {{-- ═══════════════════════════════════════════ HERO SECTION ═══════════════════════════════════════════ --}}

    <x-frontend.hero-section />

    {{-- ═══════════════════════════════════════════ BESTSELLING COURSES ═══════════════════════════════════════════ --}}

    <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8 sm:py-10 md:py-14">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-3 mb-6 sm:mb-7">
            <h2 class="font-sora text-xl sm:text-2xl font-bold">Bestselling Courses</h2>
            <a href="{{ route('courses.search') }}" class="text-purple-600 text-sm font-semibold hover:underline">
                View all courses →
            </a>
        </div>
        @php
            $maxEnrollment = $bestSellingCourses->max('enrollments_count');
        @endphp
        {{-- Courses Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach ($bestSellingCourses as $course)
                <x-frontend.course-card :course="$course" :badge="$course->enrollments_count == $maxEnrollment ? 'Bestseller' : null" />
            @endforeach
        </div>

    </section>

    {{-- ═══════════════════════════════════════════ UDEMY BUSINESS BANNER ═══════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 pb-8 sm:pb-10 md:pb-14">
        <div class="relative rounded overflow-hidden px-6 sm:px-8 md:px-12 lg:px-16 xl:px-20 py-8 sm:py-10 md:py-12 lg:py-16 flex flex-col lg:flex-row items-center justify-between gap-6 sm:gap-8 lg:gap-10"
            style="background: linear-gradient(90deg, #1c1d1f 0%, #2d1457 40%, #a435f0 100%);">

            {{-- Content Section --}}
            <div class="relative z-10 w-full lg:max-w-lg text-center lg:text-left">
                <span
                    class="inline-block bg-amber-400/20 border border-amber-400/30 text-amber-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest px-3 sm:px-3.5 py-1 rounded-full mb-3 sm:mb-4">
                    For Your Team
                </span>

                <h2 class="font-sora text-2xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight mb-3 sm:mb-4">
                    Upskill your team with<br class="hidden sm:block">
                    <span class="text-amber-400">SkillNest Business</span>
                </h2>

                <p class="text-white/80 text-sm sm:text-base leading-relaxed mb-5 sm:mb-6 md:mb-7 max-w-md mx-auto lg:mx-0">
                    Unlock 100+ top courses — anytime, anywhere. Empower your workforce with expert-led learning.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    <a href="{{ route('instructor.index') }}" target="_blank"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                        Get SkillNest Business
                    </a>
                    <a href="#"
                        class="border border-white/30 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm hover:bg-white/10 transition text-center">
                        Learn More
                    </a>
                </div>
            </div>

            {{-- Illustration --}}
            <div
                class="hidden md:flex w-48 h-36 sm:w-56 sm:h-40 lg:w-72 lg:h-52 rounded bg-white/10 border border-white/15 items-center justify-center text-6xl sm:text-7xl lg:text-8xl shrink-0 relative z-10">
                🏢
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════ TOP CATEGORIES ═══════════════════════════════════════════ --}}
    <section class="bg- py-8 sm:py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-3 mb-6 sm:mb-7">
                <h2 class="font-sora text-xl sm:text-2xl font-bold ">📚 Top Categories</h2>
                <a href="{{ route('categories.index') }}" class="text-purple-600 text-sm font-semibold hover:underline">
                    Explore all →
                </a>
            </div>

            {{-- Categories Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($topCategories as $topCategory)
                    <a href="{{ route('courses.search', ['category' => $topCategory->slug]) }}" class="block">
                        <div data-reveal
                            class="flex flex-col justify-center items-center h-36 bg-white border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-purple-400 hover:shadow-[0_8px_24px_rgba(164,53,240,0.12)] hover:-translate-y-1 transition-all duration-300">

                            {{-- Icon Container --}}
                            <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 mb-3 shrink-0">
                                <i class="fas {{ $topCategory->icon ?: 'fa-folder' }} text-lg"></i>
                            </div>

                            {{-- Category Name --}}
                            <div class="font-bold text-xs sm:text-sm text-gray-900 leading-tight text-center line-clamp-1 mb-1">
                                {{ $topCategory->name }}
                            </div>

                            {{-- Course Count --}}
                            <div class="text-[10px] sm:text-xs text-gray-400 text-center">
                                {{ $topCategory->courses_count }} courses
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </section>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8 sm:py-10 md:py-14">
        <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-3 mb-6 sm:mb-7">
            <h2 class="font-sora text-xl sm:text-2xl font-bold ">🎓 Top Instructors</h2>
            <a href="{{ url('/teach') }}" class="text-purple-600 text-sm font-semibold hover:underline">
                Become an instructor →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach ([['JS', 'Jonas Schmedtmann', 'Full-Stack Developer & Instructor', 'from-purple-600 to-violet-800', '4.7 ★', '1.2M', '8'], ['AY', 'Angela Yu', 'Developer & Lead Bootcamp Instructor', 'from-pink-500 to-red-500', '4.8 ★', '1.8M', '11'], ['SM', 'Stephane Maarek', 'AWS Expert & Solutions Architect', 'from-sky-400 to-cyan-500', '4.7 ★', '950K', '15'], ['DS', 'Dr. Daniel Scott', 'UX Designer & Adobe Certified Expert', 'from-emerald-400 to-teal-500', '4.8 ★', '720K', '9']] as $ins)
                <div data-reveal
                    class="text-center border  rounded p-5 sm:p-6 md:p-7 bg-white
                    hover:shadow-[0_8px_32px_rgba(164,53,240,0.15)] hover:-translate-y-1
                    hover:border-purple-200 transition-all duration-250 cursor-pointer">

                    {{-- Avatar --}}
                    <div
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-3 sm:mb-4 flex items-center justify-center text-xl sm:text-2xl font-bold text-white bg-gradient-to-br {{ $ins[3] }}">
                        {{ $ins[0] }}
                    </div>

                    {{-- Name --}}
                    <div class="font-bold text-sm sm:text-base  mb-1">{{ $ins[1] }}</div>

                    {{-- Title --}}
                    <div class="text-xs  mb-3 sm:mb-4 line-clamp-2">{{ $ins[2] }}</div>

                    {{-- Stats --}}
                    <div class="flex justify-center gap-3 sm:gap-4 md:gap-5 text-xs">
                        <div class="text-center">
                            <strong class="block text-sm ">{{ $ins[4] }}</strong>
                            <span class="">Rating</span>
                        </div>
                        <div class="text-center">
                            <strong class="block text-sm ">{{ $ins[5] }}</strong>
                            <span class="">Students</span>
                        </div>
                        <div class="text-center">
                            <strong class="block text-sm ">{{ $ins[6] }}</strong>
                            <span class="">Courses</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ WHY US - FEATURES ═══════════════════════════════════════════ --}}

    <section class="bg- py-14">
        <div class="max-w-7xl mx-auto px-12">
            <div class="text-center mb-10">
                <h2 class="font-sora text-2xl font-bold ">Why Millions Choose Us</h2>
                <p class=" mt-2 text-sm">Everything you need to succeed in learning and teaching.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([['fa-infinity', 'Lifetime Access', 'Buy once, learn forever. Access your courses anytime, anywhere on any device — even offline.'], ['fa-certificate', 'Certificates', 'Showcase your skills with shareable certificates. Add them to LinkedIn with one click.'], ['fa-undo', '30-Day Refund', 'Not satisfied? Get a full refund within 30 days. No questions asked, no hassles.'], ['fa-mobile-alt', 'Mobile Learning', 'Learn on the go with our iOS & Android apps. Download lessons for offline viewing.'], ['fa-users', 'Expert Instructors', 'Learn from 68,000+ real-world practitioners — skills that matter, taught by pros.'], ['fa-language', 'Multi-Language', 'Courses in 75+ languages with subtitles in 17 languages.']] as $feat)
                    <div data-reveal
                        class="bg-white border  rounded p-7
                            hover:border-purple-300 hover:shadow-[0_4px_20px_rgba(164,53,240,0.1)]
                            hover:-translate-y-0.5 transition-all duration-250">
                        <div
                            class="w-13 h-13 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-xl mb-4 w-12 h-12">
                            <i class="fa {{ $feat[0] }}"></i>
                        </div>
                        <h3 class="font-sora font-bold text-base mb-2 ">{{ $feat[1] }}</h3>
                        <p class="text-sm  leading-relaxed">{{ $feat[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ TESTIMONIALS ═══════════════════════════════════════════ --}}

    <section class="max-w-7xl mx-auto px-12 py-14">
        <div class="text-center mb-10">
            <h2 class="font-sora text-2xl font-bold ">What Our Learners Say ❤️</h2>
            <p class=" mt-2 text-sm">Real stories from real students who transformed their careers.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($reviews as $review)
                <div data-reveal class="bg-white border  rounded p-7 hover:shadow-md transition-shadow">

                    <div class="text-amber-400 text-base mb-3">
                        {{ str_repeat('★', $review->rating) }}
                    </div>

                    <p class="text-sm leading-relaxed italic mb-5">
                        "{{ $review->review }}"
                    </p>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-11 h-11 rounded-full bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ $review->user?->initials() }}
                        </div>

                        <div>
                            <div class="font-semibold text-sm ">
                                {{ $review->user->name }}
                            </div>

                            <div class="text-xs ">
                                {{ $review->course->title ?? '' }}
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ BECOME AN INSTRUCTOR CTA ═══════════════════════════════════════════ --}}

    <section style="background: linear-gradient(135deg, #1c1d1f 0%, #2d1457 100%);">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 md:py-20 flex flex-col lg:flex-row items-center justify-between gap-8 sm:gap-10">

            {{-- Content Section --}}
            <div class="max-w-xl w-full text-center lg:text-left">
                <p class="text-amber-400 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-2 sm:mb-3">
                    💼 Start Teaching Today
                </p>

                <h2 class="font-sora text-2xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight mb-3 sm:mb-4">
                    Turn Your Knowledge<br class="hidden sm:block">
                    Into <span class="text-purple-300">Income</span>
                </h2>

                <p class="text-white/70 text-sm sm:text-base leading-relaxed mb-6 sm:mb-8 max-w-md mx-auto lg:mx-0">
                    Join 68,000+ instructors teaching on SkillNest. Set your own schedule, reach millions of learners
                    globally,
                    and earn with every enrollment.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    <a href="{{ route('instructor.dashboard') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 sm:py-3.5 rounded text-sm transition text-center">
                        Start Teaching →
                    </a>
                    <a href="#"
                        class="border border-white/30 text-white font-semibold px-6 sm:px-8 py-3 sm:py-3.5 rounded text-sm hover:bg-white/10 transition text-center">
                        Learn More
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 w-full lg:w-auto justify-center">
                @foreach ([['$3.5L', 'Avg Annual Earnings'], ['57M+', 'Potential Learners'], ['$600M', 'Paid to Instructors']] as $s)
                    <div class="bg-white/7 border border-white/12 rounded px-6 sm:px-8 py-5 sm:py-6 text-center min-w-[120px] sm:min-w-[140px]"
                        style="background:rgba(255,255,255,0.07);border-color:rgba(255,255,255,0.12);">
                        <div class="font-sora text-2xl sm:text-3xl font-extrabold text-amber-400">{{ $s[0] }}</div>
                        <div class="text-xs text-white/60 mt-1 sm:mt-1.5">{{ $s[1] }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

@endsection
