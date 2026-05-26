@extends('frontend.pages.instructor.layout')
@section('title', 'Courses - Instructor')
@section('content')

    <div class="min-h-screen bg-white">

        {{-- Page Header --}}
        <div class="border-b border-gray-200 bg-white sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h1 class="font-sora text-xl sm:text-2xl font-bold">Courses</h1>
                    <a href="{{ route('instructor.create') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                        <i class="fas fa-plus"></i>
                        <span>New Course</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6">

            {{-- Search Bar --}}
            <div class="mb-4 sm:mb-6">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="search-input" placeholder="Search your courses"
                        class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition text-sm sm:text-base">
                </div>
            </div>

            {{-- Filter Tabs --}}
            <div class="border-b border-gray-200 mb-4 sm:mb-6 -mx-4 sm:mx-0">
                <div class="flex gap-4 sm:gap-8 overflow-x-auto px-4 sm:px-0 no-scrollbar">
                    <button onclick="filterCourses('all')"
                        class="filter-tab active pb-3 sm:pb-4 px-1 font-semibold text-xs sm:text-sm whitespace-nowrap border-b-2 transition">
                        All courses <span class="course-count">({{ $courses->count() }})</span>
                    </button>
                    <button onclick="filterCourses('published')"
                        class="filter-tab pb-3 sm:pb-4 px-1 font-semibold text-xs sm:text-sm whitespace-nowrap border-b-2 transition">
                        Published <span class="course-count">({{ $courses->where('status', 'published')->count() }})</span>
                    </button>
                    <button onclick="filterCourses('draft')"
                        class="filter-tab pb-3 sm:pb-4 px-1 font-semibold text-xs sm:text-sm whitespace-nowrap border-b-2 transition">
                        Draft <span class="course-count">({{ $courses->where('status', 'draft')->count() }})</span>
                    </button>
                    <button onclick="filterCourses('pending')"
                        class="filter-tab pb-3 sm:pb-4 px-1 font-semibold text-xs sm:text-sm whitespace-nowrap border-b-2 transition">
                        Pending <span class="course-count">({{ $courses->where('status', 'pending')->count() }})</span>
                    </button>
                </div>
            </div>

            {{-- Sort Dropdown --}}
            <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-xs sm:text-sm text-gray-600">
                    <span id="visible-count">{{ $courses->count() }}</span> courses
                </p>
                <select id="sort-select"
                    class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 sm:px-4 py-2 text-xs sm:text-sm outline-none focus:border-purple-500 cursor-pointer">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="a-z">Title: A-Z</option>
                    <option value="z-a">Title: Z-A</option>
                    <option value="published">Recently Published</option>
                </select>
            </div>

            {{-- Courses List --}}
            <div id="courses-container" class="space-y-4">
                @forelse($courses as $course)
                    <div class="course-item border border-gray-200 rounded-lg hover:shadow-md transition"
                        data-status="{{ $course->status }}" data-title="{{ strtolower($course->title) }}"
                        data-created="{{ $course->created_at }}">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">

                                {{-- Thumbnail --}}
                                <div class="flex-shrink-0 w-full sm:w-40 md:w-60">
                                    <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: 'https://placehold.co/240x135/667eea/white?text=Course' }}"
                                        alt="{{ $course->title }}" class="w-full h-auto rounded-lg border border-gray-200">
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row items-start justify-between gap-3 mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-base sm:text-lg font-bold text-gray-900 mb-2 hover:text-purple-600 cursor-pointer">
                                                <a href="{{ route('instructor.show', $course->id) }}">
                                                    {{ $course->title }}
                                                </a>
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-600 mb-3 line-clamp-2">
                                                {{ $course->description ?? 'No description available' }}
                                            </p>
                                        </div>

                                        {{-- Status Badge --}}
                                        @if ($course->status === 'published')
                                            <span
                                                class="px-2 sm:px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded whitespace-nowrap">
                                                PUBLIC
                                            </span>
                                        @elseif($course->status === 'draft')
                                            <span
                                                class="px-2 sm:px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded whitespace-nowrap">
                                                DRAFT
                                            </span>
                                        @elseif($course->status === 'pending')
                                            <span
                                                class="px-2 sm:px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded whitespace-nowrap">
                                                PENDING
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Meta Info --}}
                                    <div
                                        class="flex flex-wrap items-center gap-3 sm:gap-6 text-xs sm:text-sm text-gray-600 mb-4">
                                        <span><i class="fas fa-star text-amber-500 mr-1"></i>
                                            {{ number_format($course->average_rating ?? 0, 1) }}</span>
                                        <span><i class="fas fa-user-graduate mr-1"></i>
                                            {{ $course->enrollments_count ?? 0 }}</span>
                                        <span><i class="fas fa-comment mr-1"></i> {{ $course->reviews_count ?? 0 }}</span>
                                        <span class="hidden sm:inline"><i class="fas fa-chart-line mr-1"></i>
                                            {{ $course->level ?? 'All Levels' }}</span>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('instructor.edit', $course->id) }}"
                                            class="px-3 sm:px-4 py-2 border border-gray-900 text-gray-900 font-bold text-xs sm:text-sm rounded hover:bg-gray-900 hover:text-white transition">
                                            Manage Course
                                        </a>
                                        <a href="{{ route('courses.show', $course->slug) }}" target="_blank"
                                            class="px-3 sm:px-4 py-2 border border-gray-300 text-gray-700 font-semibold text-xs sm:text-sm rounded hover:bg-gray-50 transition">
                                            Preview
                                        </a>

                                        {{-- More Options --}}
                                        <div class="relative ml-auto" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="px-3 py-2 hover:bg-gray-100 rounded transition">
                                                <i class="fas fa-ellipsis-h text-gray-600"></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-cloak
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute right-0 top-full mt-2 w-48 sm:w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-20">
                                                <hr class="my-2">
                                                <form action="{{ route('instructor.destroy', $course->id) }}"
                                                    method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-xs sm:text-sm text-red-600 hover:bg-red-50">
                                                        <i class="fas fa-trash w-5 mr-2"></i> Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="text-center py-12 sm:py-16">
                        <div
                            class="w-24 h-24 sm:w-32 sm:h-32 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-graduation-cap text-5xl sm:text-6xl text-purple-400"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Jump Into Course Creation</h3>
                        <p class="text-sm sm:text-base text-gray-600 mb-6">All you need is a computer and your expertise
                        </p>
                        <a href="{{ route('instructor.create') }}"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 sm:px-7 py-3 rounded text-sm transition text-center">
                            <i class="fas fa-plus"></i>
                            Create Your Course
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- No Results Message --}}
            <div id="no-results" class="hidden text-center py-12">
                <i class="fas fa-search text-5xl sm:text-6xl text-gray-300 mb-4"></i>
                <p class="text-sm sm:text-base text-gray-600">No courses found matching your search.</p>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .filter-tab {
                border-bottom-color: transparent;
                color: #6b7280;
            }

            .filter-tab.active {
                border-bottom-color: #9333ea;
                color: #9333ea;
            }

            .filter-tab:hover {
                color: #9333ea;
            }

            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Filter Tabs
            const tabs = document.querySelectorAll('.filter-tab');
            const courses = document.querySelectorAll('.course-item');
            let currentFilter = 'all';
            let currentSort = 'newest';

            function filterCourses(status) {
                currentFilter = status;

                // Update active tab
                tabs.forEach(tab => {
                    if (tab.textContent.toLowerCase().includes(status)) {
                        tab.classList.add('active', 'text-purple-600', 'border-purple-600');
                        tab.classList.remove('text-gray-600', 'border-transparent');
                    } else {
                        tab.classList.remove('active', 'text-purple-600', 'border-purple-600');
                        tab.classList.add('text-gray-600', 'border-transparent');
                    }
                });

                applyFiltersAndSort();
            }

            // Search
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', (e) => {
                applyFiltersAndSort();
            });

            // Sort
            const sortSelect = document.getElementById('sort-select');
            sortSelect.addEventListener('change', (e) => {
                currentSort = e.target.value;
                applyFiltersAndSort();
            });

            function applyFiltersAndSort() {
                const searchTerm = searchInput.value.toLowerCase();
                let visibleCourses = Array.from(courses);
                let visibleCount = 0;

                // Filter
                visibleCourses.forEach(course => {
                    const status = course.dataset.status;
                    const title = course.dataset.title;

                    const matchesFilter = currentFilter === 'all' || status === currentFilter;
                    const matchesSearch = title.includes(searchTerm);

                    if (matchesFilter && matchesSearch) {
                        course.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        course.classList.add('hidden');
                    }
                });

                // Sort visible courses
                const container = document.getElementById('courses-container');
                visibleCourses = visibleCourses.filter(c => !c.classList.contains('hidden'));

                visibleCourses.sort((a, b) => {
                    switch (currentSort) {
                        case 'newest':
                            return new Date(b.dataset.created) - new Date(a.dataset.created);
                        case 'oldest':
                            return new Date(a.dataset.created) - new Date(b.dataset.created);
                        case 'a-z':
                            return a.dataset.title.localeCompare(b.dataset.title);
                        case 'z-a':
                            return b.dataset.title.localeCompare(a.dataset.title);
                        default:
                            return 0;
                    }
                });

                // Re-append in sorted order
                visibleCourses.forEach(course => container.appendChild(course));

                // Update count
                document.getElementById('visible-count').textContent = visibleCount;

                // Show/hide no results
                document.getElementById('no-results').classList.toggle('hidden', visibleCount > 0);
            }



            // Initialize active tab styling
            document.querySelector('.filter-tab.active').classList.add('text-purple-600', 'border-purple-600');
        </script>
    @endpush

@endsection
