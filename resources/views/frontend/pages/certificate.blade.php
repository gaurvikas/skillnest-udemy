@extends('frontend.layouts.app')
@section('title', 'Certificate of Completion - SkillNest')
@section('content')

    <div class="bg-gray-50 min-h-screen py-8 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <a href="{{ route('my-learning.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-purple-600 mb-6 transition">
                <i class="fas fa-arrow-left"></i>
                <span class="text-sm font-semibold">Back to My Learning</span>
            </a>

            {{-- Certificate Container --}}
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
                                    <p class="text-xs sm:text-sm font-bold text-gray-900">{{ $course->instructor->name }}
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

            {{-- Action Buttons --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Share Your Achievement</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Download PDF --}}
                    <a href="{{ route('certificate.download', $course->id) }}" target="_blank"
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg">
                        Download Certificate
                    </a>

                </div>

                {{-- Certificate ID --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Certificate ID: <span
                            class="font-mono font-bold text-gray-900">{{ $certificate->certificate_number }}</span>
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Verify at: {{ url('/verify-certificate') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
