{{-- resources/views/pages/courses.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'All Courses - SkillNest')
@section('content')

    <div class="hidden sm:block bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('index') }}" class="hover:text-purple-600 transition">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span
                    class="text-gray-900 font-semibold">{{ request()->query('query') ?? request()->query('category') }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8 md:py-10">

        <div class="mb-6">
            <h1 class="font-sora text-2xl sm:text-3xl font-extrabold text-gray-900 mb-1">All Courses</h1>
        </div>

        {{-- Mobile Filter Toggle --}}
        <button id="filter-toggle" onclick="toggleFilters()"
            class="md:hidden w-full flex items-center justify-between border border-gray-200 rounded px-4 py-3 mb-5 text-sm font-semibold text-gray-700 hover:border-purple-400 transition">
            <span><i class="fa fa-sliders-h mr-2 text-purple-500"></i> Filters</span>
            <i class="fa fa-chevron-down text-gray-500" id="filter-chevron"></i>
        </button>

        <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-start">
            {{-- SIDEBAR --}}

            <x-frontend.filter />

            {{-- GRID --}}
            <div class="flex-1 w-full min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                    <p class="text-gray-500 text-sm">Showing {{ $courses->count() }} results for <strong
                            class="text-gray-700">{{ request()->query('query') ?? request()->query('category') }}</strong>
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 hidden sm:block">Sort by:</span>
                        <select name="sort" onchange="window.location.href='?sort='+this.value"
                            class="border border-gray-200 rounded text-sm px-3 py-1.5 outline-none focus:border-purple-400 cursor-pointer">

                            <option value="relevant" {{ request()->query('sort') == 'relevant' ? 'selected' : '' }}>Most
                                Relevant</option>
                            <option value="rating" {{ request()->query('sort') == 'rating' ? 'selected' : '' }}>Highest
                                Rated</option>
                            <option value="reviews" {{ request()->query('sort') == 'reviews' ? 'selected' : '' }}>Most
                                Reviewed</option>
                            <option value="newest" {{ request()->query('sort') == 'newest' ? 'selected' : '' }}>Newest
                            </option>

                        </select>
                    </div>
                </div>
                {{-- @php
                    $maxEnrollment = $bestSellingCourses->max('enrollments_count');
                @endphp --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
                    @foreach ($courses as $course)
                        <x-frontend.course-card :course="$course" badge="Bestseller" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <x-frontend.pagination :model="$courses" />

            </div>
        </div>
    </div>

@endsection
