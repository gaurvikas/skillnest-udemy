@extends('frontend.layouts.app')
@section('title', 'My Learning - SkillNest')
@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8 md:py-10">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-sora text-2xl sm:text-3xl font-extrabold text-gray-900">My Learning</h1>
                <p class="text-gray-400 text-sm mt-1">Welcome back, <span
                        class="text-purple-600 font-semibold">{{ $user->name }}</span>
                    👋</p>
            </div>
            <a href="{{ route('courses.search') }}"
                class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2.5 rounded text-sm transition self-start sm:self-auto">
                <i class="fa fa-plus text-xs"></i> Explore More Courses
            </a>
        </div>

        {{-- STATS ROW --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <div class="bg-white border border-gray-200 rounded p-4 sm:p-5 flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded bg-purple-50 flex items-center justify-center shrink-0">
                    <i class="fa fa-book-open text-purple-600 text-base sm:text-lg"></i>
                </div>
                <div>
                    <div class="font-sora font-extrabold text-xl sm:text-2xl text-gray-900">
                        {{ $enrollments->count() }}
                    </div>
                    <div class="text-xs text-gray-400">Enrolled Courses</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded p-4 sm:p-5 flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded bg-green-50 flex items-center justify-center shrink-0">
                    <i class="fa fa-check-circle text-green-600 text-base sm:text-lg"></i>
                </div>
                <div>
                    <div class="font-sora font-extrabold text-xl sm:text-2xl text-gray-900">
                        {{ $completedCoursesCount ?? 0 }}
                    </div>
                    <div class="text-xs text-gray-400">Completed</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded p-4 sm:p-5 flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded bg-amber-50 flex items-center justify-center shrink-0">
                    <i class="fa fa-clock text-amber-600 text-base sm:text-lg"></i>
                </div>
                <div>
                    <div class="font-sora font-extrabold text-xl sm:text-2xl text-gray-900">
                        {{ $hoursLearned ?? 0 }}
                    </div>
                    <div class="text-xs text-gray-400">Hours Learned</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded p-4 sm:p-5 flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="fa fa-certificate text-blue-600 text-base sm:text-lg"></i>
                </div>
                <div>
                    <div class="font-sora font-extrabold text-xl sm:text-2xl text-gray-900">
                        {{ $certificates ?? 0 }}
                    </div>
                    <div class="text-xs text-gray-400">Certificates</div>
                </div>
            </div>
        </div>

        {{-- TABS --}}
        <div class="flex gap-0 border-b border-gray-200 mb-7 overflow-x-auto no-scrollbar">
            @foreach (['All Courses', 'In Progress', 'Completed'] as $i => $tab)
                <button onclick="switchTab({{ $i }})" id="tab-btn-{{ $i }}"
                    class="tab-btn px-4 sm:px-5 py-3 text-xs sm:text-sm font-medium whitespace-nowrap border-b-2 transition-colors
                           {{ $i === 0 ? 'text-purple-600 border-purple-600' : 'text-gray-500 border-transparent hover:text-purple-600' }}">
                    {{ $tab }}
                    @if ($i === 0)
                        <span
                            class="ml-1.5 bg-purple-100 text-purple-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $enrollments->count() }}</span>
                    @endif
                    @if ($i === 1)
                        <span
                            class="ml-1.5 bg-amber-100 text-amber-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $incompleteCoursesCount ?? 0 }}</span>
                    @endif
                    @if ($i === 2)
                        <span
                            class="ml-1.5 bg-green-100 text-green-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $completedCoursesCount ?? 0 }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- SEARCH + SORT --}}
        <div class="flex flex-col sm:flex-row gap-3 mb-7">
            <div
                class="flex flex-1 items-center border-2 border-gray-200 rounded overflow-hidden focus-within:border-purple-500 transition">
                <span class="pl-4 text-gray-400"><i class="fa fa-search text-sm"></i></span>
                <input type="text" id="search-input" placeholder="Search your courses..."
                    class="flex-1 border-none outline-none px-3 py-2.5 text-sm placeholder-gray-300">
            </div>
            <select id="sort-select"
                class="border-2 border-gray-200 rounded px-4 py-2.5 text-sm outline-none focus:border-purple-500 transition cursor-pointer text-gray-600">
                <option value="recent">Recently Accessed</option>
                <option value="title">Title A–Z</option>
                <option value="progress">Progress</option>
                <option value="newest">Most Recent</option>
            </select>
        </div>

        {{-- COURSE CARDS GRID --}}
        <div id="courses-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">

            @forelse ($enrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $progress = $enrollment->progress_percentage ?? 0;
                    $status = $progress >= 100 ? 'completed' : ($progress > 0 ? 'in-progress' : 'not-started');
                    $statusLabel = $progress >= 100 ? 'Completed' : ($progress > 0 ? 'In Progress' : 'Not Started');
                    $statusColor = $progress >= 100 ? 'bg-green-400' : ($progress > 0 ? 'bg-amber-400' : 'bg-gray-400');
                    $thumbnail = $course->getFirstMediaUrl('thumbnail') ?: null;
                @endphp

                <div data-reveal
                    class="course-card bg-white border border-gray-200 rounded overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer group"
                    data-status="{{ $status }}" data-title="{{ strtolower($course->title) }}"
                    data-progress="{{ $progress }}" data-enrolled="{{ $enrollment->created_at->timestamp }}">

                    {{-- Thumbnail --}}
                    <div
                        class="relative h-36 bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center overflow-hidden">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">📚</span>
                        @endif

                        {{-- Status Badge --}}
                        <span
                            class="absolute top-2 right-2 {{ $statusColor }} text-gray-900 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        {{-- Course Title --}}
                        <a href="{{ route('courses.show', $course->slug) }}" class="block">
                            <h3
                                class="font-sora font-bold text-sm text-gray-900 leading-snug mb-1 line-clamp-2 hover:text-purple-600 transition">
                                {{ $course->title }}
                            </h3>
                        </a>

                        {{-- Instructor --}}
                        <p class="text-xs text-gray-400 mb-3">{{ $course->instructor->name ?? 'Instructor' }}</p>

                        {{-- Progress Bar --}}
                        <div class="mb-1.5">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500 font-medium">Progress</span>
                                <span class="text-purple-600 font-bold">{{ $progress }}%</span>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-purple-600 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        {{-- Enrollment Date --}}
                        <p class="text-[11px] text-gray-400 mb-3">
                            Enrolled:
                            {{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d M Y') : 'N/A' }}
                        </p>

                        {{-- Bottom Actions --}}
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                <i class="fa fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($enrollment->created_at)->diffForHumans() }}
                            </span>

                            {{-- Learn Button --}}
                            <a href="{{ route('course.learn', $course->slug) }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-3 py-1.5 rounded transition">
                                {{ $progress > 0 ? 'Continue' : 'Start' }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- No courses enrolled --}}
                <div id="empty-state" class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="text-5xl mb-4">📭</div>
                    <h3 class="font-sora font-bold text-gray-700 text-lg mb-2">No courses yet!</h3>
                    <p class="text-gray-400 text-sm mb-5">Enroll in a course to start learning today.</p>
                    <a href="{{ route('courses.search') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2.5 rounded text-sm transition">
                        Explore Courses
                    </a>
                </div>
            @endforelse

            {{-- Add More Card --}}
            @if ($enrollments->count() > 0)
                <a href="{{ route('courses.search') }}" id="add-more-card" data-reveal
                    class="border-2 border-dashed border-gray-200 rounded flex flex-col items-center justify-center p-8 cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all group min-h-[260px]">
                    <div
                        class="w-14 h-14 rounded-full bg-gray-100 group-hover:bg-purple-100 flex items-center justify-center mb-4 transition-colors">
                        <i class="fa fa-plus text-gray-400 group-hover:text-purple-600 text-xl transition-colors"></i>
                    </div>
                    <p
                        class="font-sora font-bold text-sm text-gray-500 group-hover:text-purple-600 transition-colors text-center mb-1">
                        Find More Courses
                    </p>
                    <p class="text-xs text-gray-400 text-center">Explore more courses</p>
                </a>
            @endif

        </div>

        {{-- No Results Message (Hidden by default) --}}
        <div id="no-results" class="hidden col-span-full flex flex-col items-center justify-center py-16 text-center">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="font-sora font-bold text-gray-700 text-lg mb-2">No courses found</h3>
            <p class="text-gray-400 text-sm mb-5">Try adjusting your filters or search query.</p>
        </div>

        {{-- LEARNING ACTIVITY --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Weekly Activity --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded p-5 sm:p-6">
                <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900 mb-5">📅 Weekly Learning Activity</h2>
                <div class="flex items-end justify-between gap-2 h-32 mb-3">
                    @foreach ([['Mon', '45', 'bg-purple-200'], ['Tue', '90', 'bg-purple-500'], ['Wed', '60', 'bg-purple-300'], ['Thu', '120', 'bg-purple-600'], ['Fri', '30', 'bg-purple-200'], ['Sat', '75', 'bg-purple-400'], ['Sun', '0', 'bg-gray-100']] as $day)
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <div class="w-full rounded-t-lg {{ $day[2] }} transition-all hover:opacity-80"
                                style="height: {{ round(($day[1] / 120) * 100) }}%"></div>
                            <span class="text-[10px] text-gray-400">{{ $day[0] }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 text-center">Minutes learned this week: <span
                        class="text-purple-600 font-bold">420 min (7 hrs)</span></p>
            </div>

            {{-- Certificates --}}
            <div class="bg-white border border-gray-200 rounded p-5 sm:p-6">
                <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900 mb-5">🏆 Certificates Earned</h2>
                <div class="space-y-4">
                    @forelse ($myCertificates as $myCertificate)
                        <div
                            class="flex items-center gap-3 p-3 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-100 rounded">

                            <div
                                class="w-10 h-10 bg-gradient-to-br from-amber-400 to-yellow-400 rounded flex items-center justify-center text-lg shrink-0">
                                🏆
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-xs text-gray-900 line-clamp-1">
                                    {{ $myCertificate->course->title }}
                                </p>
                                <p class="text-[11px] text-gray-400">
                                    {{ $myCertificate->user->name }} • {{ $myCertificate->issued_at->format('M Y') }}
                                </p>
                            </div>

                            <a href="{{ route('certificate.show', $myCertificate->course->slug) }}"
                                class="text-amber-600 hover:text-amber-700 text-xs font-bold shrink-0">
                                <i class="fa fa-download"></i>
                            </a>

                        </div>
                    @empty
                        <div class="text-center text-gray-400 text-sm py-6">
                            No certificates found 🏆
                        </div>
                    @endforelse
                </div>

                <a href="#" class="block text-center text-xs text-purple-600 font-semibold hover:underline mt-2">
                    View All Certificates →
                </a>
            </div>
        </div>
    </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Current filter state
        let currentFilter = 'all';
        let currentSearch = '';
        let currentSort = 'recent';

        // Tab switching with filter
        function switchTab(index) {
            // Update tab UI
            document.querySelectorAll('.tab-btn').forEach((btn, i) => {
                if (i === index) {
                    btn.classList.add('text-purple-600', 'border-purple-600');
                    btn.classList.remove('text-gray-500', 'border-transparent');
                } else {
                    btn.classList.remove('text-purple-600', 'border-purple-600');
                    btn.classList.add('text-gray-500', 'border-transparent');
                }
            });

            // Set filter based on tab
            if (index === 0) currentFilter = 'all';
            else if (index === 1) currentFilter = 'in-progress';
            else if (index === 2) currentFilter = 'completed';

            // Apply filters
            filterCourses();
        }

        // Main filter function
        function filterCourses() {
            const cards = document.querySelectorAll('.course-card');
            const noResults = document.getElementById('no-results');
            const emptyState = document.getElementById('empty-state');
            const addMoreCard = document.getElementById('add-more-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                const title = card.getAttribute('data-title');

                // Check filter match
                let filterMatch = false;
                if (currentFilter === 'all') {
                    filterMatch = true;
                } else if (currentFilter === 'in-progress') {
                    filterMatch = (status === 'in-progress');
                } else if (currentFilter === 'completed') {
                    filterMatch = (status === 'completed');
                }

                // Check search match
                const searchMatch = title.includes(currentSearch.toLowerCase());

                // Show/hide card
                if (filterMatch && searchMatch) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Handle empty states
            if (visibleCount === 0) {
                if (noResults) noResults.classList.remove('hidden');
                if (addMoreCard) addMoreCard.style.display = 'none';
            } else {
                if (noResults) noResults.classList.add('hidden');
                if (addMoreCard) addMoreCard.style.display = '';
            }

            // Sort courses
            sortCourses();
        }

        // Sort courses
        function sortCourses() {
            const grid = document.getElementById('courses-grid');
            const cards = Array.from(document.querySelectorAll('.course-card'));
            const addMoreCard = document.getElementById('add-more-card');

            // Remove add-more card temporarily
            if (addMoreCard && addMoreCard.parentNode === grid) {
                grid.removeChild(addMoreCard);
            }

            // Sort based on current sort option
            cards.sort((a, b) => {
                if (currentSort === 'title') {
                    return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
                } else if (currentSort === 'progress') {
                    return parseInt(b.getAttribute('data-progress')) - parseInt(a.getAttribute('data-progress'));
                } else if (currentSort === 'newest') {
                    return parseInt(b.getAttribute('data-enrolled')) - parseInt(a.getAttribute('data-enrolled'));
                } else { // recent (default)
                    return parseInt(b.getAttribute('data-enrolled')) - parseInt(a.getAttribute('data-enrolled'));
                }
            });

            // Re-append sorted cards
            cards.forEach(card => grid.appendChild(card));

            // Re-add add-more card at the end
            if (addMoreCard) {
                grid.appendChild(addMoreCard);
            }
        }

        // Search input listener
        document.getElementById('search-input')?.addEventListener('input', (e) => {
            currentSearch = e.target.value;
            filterCourses();
        });

        // Sort select listener
        document.getElementById('sort-select')?.addEventListener('change', (e) => {
            currentSort = e.target.value;
            sortCourses();
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            filterCourses();
        });
    </script>
@endpush
