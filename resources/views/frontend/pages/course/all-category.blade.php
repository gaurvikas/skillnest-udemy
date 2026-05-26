@extends('frontend.layouts.app')
@section('title', 'All Categories - SkillNest')

@section('content')

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 text-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4">Explore Top Categories</h1>
            <p class="text-base sm:text-lg lg:text-xl text-purple-100 max-w-2xl mx-auto">
                Discover thousands of courses across all categories. Start your learning journey today!
            </p>
        </div>
    </section>

    {{-- Breadcrumb --}}
    <div class="hidden sm:block bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('index') }}" class="hover:text-purple-600 transition">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-900 font-semibold">All Categories</span>
            </div>
        </div>
    </div>

    {{-- All Categories Section --}}
    <section class="bg-gray-50 py-8 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-6 sm:mb-8 lg:mb-12">All Categories</h2>

            @if ($categories->isNotEmpty())

                @php
                    $iconMap = [
                        'development' => [
                            'icon' => 'fas fa-laptop-code',
                            'bg' => 'bg-blue-100',
                            'color' => 'text-blue-600',
                        ],
                        'business' => [
                            'icon' => 'fas fa-briefcase',
                            'bg' => 'bg-green-100',
                            'color' => 'text-green-600',
                        ],
                        'finance' => [
                            'icon' => 'fas fa-chart-line',
                            'bg' => 'bg-emerald-100',
                            'color' => 'text-emerald-600',
                        ],
                        'accounting' => [
                            'icon' => 'fas fa-calculator',
                            'bg' => 'bg-emerald-100',
                            'color' => 'text-emerald-600',
                        ],
                        'design' => ['icon' => 'fas fa-palette', 'bg' => 'bg-pink-100', 'color' => 'text-pink-600'],
                        'marketing' => [
                            'icon' => 'fas fa-bullhorn',
                            'bg' => 'bg-orange-100',
                            'color' => 'text-orange-600',
                        ],
                        'it' => ['icon' => 'fas fa-server', 'bg' => 'bg-purple-100', 'color' => 'text-purple-600'],
                        'software' => [
                            'icon' => 'fas fa-server',
                            'bg' => 'bg-purple-100',
                            'color' => 'text-purple-600',
                        ],
                        'personal' => [
                            'icon' => 'fas fa-user-tie',
                            'bg' => 'bg-indigo-100',
                            'color' => 'text-indigo-600',
                        ],
                        'health' => ['icon' => 'fas fa-heartbeat', 'bg' => 'bg-red-100', 'color' => 'text-red-600'],
                        'fitness' => ['icon' => 'fas fa-dumbbell', 'bg' => 'bg-red-100', 'color' => 'text-red-600'],
                        'music' => ['icon' => 'fas fa-music', 'bg' => 'bg-cyan-100', 'color' => 'text-cyan-600'],
                        'photography' => [
                            'icon' => 'fas fa-camera',
                            'bg' => 'bg-yellow-100',
                            'color' => 'text-yellow-600',
                        ],
                        'video' => ['icon' => 'fas fa-video', 'bg' => 'bg-yellow-100', 'color' => 'text-yellow-600'],
                        'teaching' => [
                            'icon' => 'fas fa-chalkboard-teacher',
                            'bg' => 'bg-teal-100',
                            'color' => 'text-teal-600',
                        ],
                        'language' => ['icon' => 'fas fa-language', 'bg' => 'bg-sky-100', 'color' => 'text-sky-600'],
                        'science' => ['icon' => 'fas fa-flask', 'bg' => 'bg-lime-100', 'color' => 'text-lime-600'],
                        'data' => ['icon' => 'fas fa-database', 'bg' => 'bg-violet-100', 'color' => 'text-violet-600'],
                        'ai' => ['icon' => 'fas fa-robot', 'bg' => 'bg-violet-100', 'color' => 'text-violet-600'],
                        'security' => [
                            'icon' => 'fas fa-shield-alt',
                            'bg' => 'bg-slate-100',
                            'color' => 'text-slate-600',
                        ],
                        'default' => [
                            'icon' => 'fas fa-layer-group',
                            'bg' => 'bg-gray-100',
                            'color' => 'text-gray-600',
                        ],
                    ];

                    function getCategoryIcon($name, $iconMap)
                    {
                        $lower = strtolower($name);
                        foreach ($iconMap as $key => $config) {
                            if ($key !== 'default' && str_contains($lower, $key)) {
                                return $config;
                            }
                        }
                        return $iconMap['default'];
                    }
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

                    @foreach ($categories as $category)
                        @php
                            $catName = $category->name ?? 'Category';
                            $iconConfig = getCategoryIcon($catName, $iconMap);
                            $children = $category->children;
                            $courseCount = $category->courses_count ?? null;
                        @endphp

                        <div
                            class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6 hover:shadow-lg hover:border-purple-200 transition-all duration-200">

                            {{-- Category Header --}}
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg {{ $iconConfig['bg'] }} flex items-center justify-center shrink-0">
                                    @if ($category->icon)
                                        <i class="fas {{ $category->icon }} {{ $iconConfig['color'] }} text-lg sm:text-xl"></i>
                                    @else
                                        <i
                                            class="{{ $iconConfig['icon'] }} {{ $iconConfig['color'] }} text-lg sm:text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 leading-tight">
                                        {{ $catName }}</h3>
                                    @if ($children->isNotEmpty())
                                        <p class="text-xs text-gray-400">{{ $children->count() }} subcategories</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Subcategories or Browse Link --}}
                            @if ($children->isNotEmpty())
                                <ul class="space-y-2 mb-4">
                                    @foreach ($children->take(6) as $child)
                                        <li>
                                            <a href="{{ route('courses.search', ['category' => $child->slug ?? $child->id]) }}"
                                                class="flex items-center gap-2 text-sm text-gray-600 hover:text-purple-600 transition-colors duration-150 group">
                                                <span
                                                    class="w-1 h-1 rounded-full bg-gray-300 group-hover:bg-purple-400 transition-colors shrink-0"></span>
                                                <span class="line-clamp-1">{{ $child->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    @if ($children->count() > 6)
                                        <span class="text-xs text-gray-400">+{{ $children->count() - 6 }} more
                                            subcategories</span>
                                    @else
                                        <span></span>
                                    @endif
                                    <a href="{{ route('courses.search', ['category' => $category->slug]) }}"
                                        class="inline-flex items-center gap-1 text-xs text-purple-600 hover:text-purple-800 font-semibold transition">
                                        View All <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            @else
                                {{-- No subcategories - show description and browse link --}}
                                @if ($category->description)
                                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $category->description }}</p>
                                @endif

                                <div class="pt-3 border-t border-gray-100">
                                    <a href="{{ route('courses.search', ['category' => $category->slug]) }}"
                                        class="inline-flex items-center gap-2 text-sm text-purple-600 hover:text-purple-800 font-semibold transition group">
                                        Browse Courses
                                        <i
                                            class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Categories Found</h3>
                    <p class="text-gray-400 text-sm">Categories will appear here once they are added.</p>
                    <a href="{{ route('courses.search') }}"
                        class="inline-block mt-6 bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-purple-700 transition text-sm">
                        Browse All Courses
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">
                Can't find what you're looking for?
            </h2>
            <p class="text-base sm:text-lg text-purple-100 mb-6 sm:mb-8">
                Browse all courses or get in touch with us to suggest a new category
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('courses.search') }}"
                    class="bg-white text-purple-600 hover:bg-gray-100 font-bold py-3 px-6 sm:px-8 rounded-lg transition text-sm sm:text-base">
                    Browse All Courses
                </a>
                <a href="#"
                    class="bg-purple-800 hover:bg-purple-900 text-white font-bold py-3 px-6 sm:px-8 rounded-lg transition border-2 border-purple-400 text-sm sm:text-base">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection
