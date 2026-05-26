{{-- resources/views/frontend/pages/wishlist.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'My Wishlist - SkillNest')
@section('content')

    <div class="bg-gray-50 min-h-screen py-6 sm:py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <h1 class="font-sora text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 sm:mb-8">
                    My Wishlist
                </h1>
                <p class="text-sm text-gray-400 mb-5 border-b border-gray-200 pb-4">
                    <span class="font-semibold text-gray-900">
                        {{ $wishlistItems->count() }}</span> courses in your wishlist
                </p>
            </div>

            @if ($wishlistItems->count() > 0)
                {{-- Wishlist Grid --}}
                <div class="grid grid-cols-1 gap-4 sm:gap-5 mb-8">
                    @foreach ($wishlistItems as $item)
                        <div
                            class="bg-white rounded sm:rounded shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 p-4 sm:p-5">

                                {{-- Course Thumbnail --}}
                                <div class="relative shrink-0 w-full sm:w-56 h-40 sm:h-32">
                                    <img src="{{ $item->course->getFirstMediaUrl('thumbnail') ?: '🤖' }}"
                                        alt="{{ $item->course->title }}" class="w-full h-full object-cover rounded">

                                    @if ($item->course->is_bestseller)
                                        <span
                                            class="absolute top-2 left-2 bg-amber-400 text-gray-900 text-xs font-bold px-2 py-1 rounded">
                                            Bestseller
                                        </span>
                                    @endif
                                </div>

                                {{-- Course Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="font-bold text-base sm:text-lg text-gray-900 hover:text-purple-600 transition line-clamp-2 mb-2">
                                                <a href="{{ route('courses.show', $item->course->slug) }}">
                                                    {{ $item->course->title }}
                                                </a>
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                                By {{ $item->course->instructor->name }}
                                            </p>

                                            {{-- Rating --}}
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="text-amber-500 font-bold text-sm">
                                                    {{ number_format($item->course->reviews()->avg('rating') ?? 0, 1) }}</span>
                                                <div class="flex text-amber-400 text-xs">
                                                    ★★★★★
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    ({{ $item->course->reviews()->count() ?? 0 }})
                                                </span>
                                            </div>

                                            {{-- Course Meta --}}
                                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                                <span class="flex items-center gap-1" x-data="{ expanded: false }">
                                                    <i class="fa fa-clock"></i>
                                                    <span x-show="!expanded">{{ min($item->course->duration, 10) }} hours</span>
                                                    <span x-show="expanded" style="display: none;">{{ $item->course->duration }} hours</span>
                                                    @if ($item->course->duration > 10)
                                                        <button @click="expanded = !expanded" type="button" class="text-purple-600 hover:text-purple-700 ml-1 font-semibold underline focus:outline-none transition-colors">
                                                            <span x-show="!expanded">+ More</span>
                                                            <span x-show="expanded" style="display: none;">- Less</span>
                                                        </button>
                                                    @endif
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-signal"></i>
                                                    {{ ucfirst($item->course->level) }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-closed-captioning"></i>
                                                    Subtitles
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Price & Actions (Desktop) --}}
                                        <div class="hidden sm:flex flex-col items-end gap-2 shrink-0">
                                            <div class="text-right">
                                                <span
                                                    class="text-2xl font-bold text-gray-900">${{ number_format($item->course->price) }}</span>
                                                @if ($item->course->original_price)
                                                    <div class="text-sm text-gray-400 line-through">
                                                        ${{ number_format($item->course->original_price) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex flex-wrap gap-2 sm:gap-3">
                                        {{-- Add to Cart --}}
                                        <button onclick="addToCart({{ $item->course->id }})"
                                            class="flex-1 sm:flex-none bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 sm:px-6 py-2.5 rounded text-sm transition shadow-sm flex items-center justify-center gap-2">
                                            
                                            <i class="fa fa-shopping-cart"></i>
                                            <span>Add to Cart</span>
                                        </button>

                                        <form action="{{ route('wishlist.destroy', $item->course->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="sm:flex-none border-2 border-red-200 hover:border-red-500 hover:bg-black-50 text-red-600 font-semibold px-4 sm:px-6 py-2.5 rounded text-sm transition flex items-center justify-center gap-2">
                                                <span>Remove</span>
                                            </button>

                                        </form>
                                    </div>

                                    {{-- Price (Mobile) --}}
                                    <div class="sm:hidden mt-3 pt-3 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-xl font-bold text-purple-600">${{ number_format($item->course->price) }}</span>
                                            @if ($item->course->original_price)
                                                <span
                                                    class="text-sm text-gray-400 line-through">${{ number_format($item->course->original_price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty Wishlist --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-8 sm:p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa fa-heart-broken text-5xl text-red-400"></i>
                        </div>
                        <h2 class="font-sora text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Your wishlist is empty</h2>
                        <p class="text-gray-600 mb-8">
                            Explore courses and save your favorites for later!
                        </p>
                        <a href="{{ route('index') }}"
                            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded transition shadow-lg">
                            <i class="fa fa-search"></i>
                            Browse Courses
                        </a>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 py-10">
                @foreach ($bestSellingCourses as $course)
                    <x-frontend.course-card :course="$course" badge="Bestseller" />
                @endforeach
            </div>

        </div>
    </div>
@endsection
