{{-- resources/views/frontend/pages/profile.blade.php --}}
@extends('frontend.layouts.app')
@section('title', 'Public Profile - SkillNest')

@section('content')
    <div class="bg-gray-50 min-h-screen">

        {{-- Header Section --}}
        <div class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center gap-6">
                    {{-- Avatar --}}
                    <div class="relative shrink-0">
                        @if (Auth::user()->getFirstMediaUrl('image'))
                            <img src="{{ Auth::user()->getFirstMediaUrl('image') }}" alt="{{ Auth::user()->name }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white/20">
                        @else
                            <div
                                class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center border-4 border-white/20">
                                <span class="text-5xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif

                        {{-- Change Photo Button --}}
                        <button onclick="document.getElementById('avatar-upload').click()"
                            class="absolute bottom-0 right-0 w-10 h-10 bg-white text-gray-900 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition">
                            <i class="fa fa-camera text-sm"></i>
                        </button>
                        <input type="file" id="avatar-upload" class="hidden" accept="image/*"
                            onchange="uploadAvatar(this)">
                    </div>

                    {{-- User Info --}}
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-2">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-300 mb-4">{{ Auth::user()->headline ?? 'Passionate Learner' }}</p>

                        {{-- Stats --}}
                        <div class="flex items-center gap-6 text-sm">
                            <div>
                                <span class="font-semibold">{{ Auth::user()->enrollments()->count() }}</span>
                                <span class="text-gray-400">courses</span>
                            </div>
                            <div>
                                <span class="font-semibold">{{ $stats['total_students'] ?? 0 }}</span>
                                <span class="text-gray-400">students taught</span>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Button --}}
                    <div class="shrink-0">
                        <a href="#"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-900 font-semibold rounded hover:bg-gray-100 transition">
                            <i class="fa fa-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Sidebar --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- About Me Card --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">About me</h2>

                        @if ($user->bio)
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $user->bio }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">No bio added yet</p>
                        @endif

                        @if (Auth::id() === $user->id)
                            <a href="#"
                                class="inline-block mt-4 text-sm text-purple-600 hover:text-purple-700 font-semibold">
                                Add bio →
                            </a>
                        @endif
                    </div>

                    {{-- Links Card --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Links</h2>

                        <div class="space-y-3">
                            @if ($user->website)
                                <a href="{{ $user->website }}" target="_blank"
                                    class="flex items-center gap-3 text-sm text-gray-700 hover:text-purple-600 transition">
                                    <i class="fa fa-globe w-5 text-gray-400"></i>
                                    <span class="flex-1 truncate">{{ $user->website }}</span>
                                </a>
                            @endif

                            @if ($user->twitter)
                                <a href="https://twitter.com/{{ $user->twitter }}" target="_blank"
                                    class="flex items-center gap-3 text-sm text-gray-700 hover:text-purple-600 transition">
                                    <i class="fab fa-twitter w-5 text-gray-400"></i>
                                    <span>@{{ $user - > twitter }}</span>
                                </a>
                            @endif

                            @if ($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank"
                                    class="flex items-center gap-3 text-sm text-gray-700 hover:text-purple-600 transition">
                                    <i class="fab fa-linkedin w-5 text-gray-400"></i>
                                    <span class="flex-1 truncate">LinkedIn Profile</span>
                                </a>
                            @endif

                            @if (!$user->website && !$user->twitter && !$user->linkedin)
                                <p class="text-gray-400 text-sm italic">No links added</p>
                            @endif
                        </div>

                        @if (Auth::id() === $user->id)
                            <a href="#"
                                class="inline-block mt-4 text-sm text-purple-600 hover:text-purple-700 font-semibold">
                                Add links →
                            </a>
                        @endif
                    </div>

                    {{-- Stats Card --}}

                </div>

                {{-- Right Content --}}
                <div class="lg:col-span-2">

                    {{-- Tabs --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                        {{-- Tab Headers --}}
                        <div class="border-b border-gray-200">
                            <div class="flex">
                                <button onclick="switchTab('courses')" data-tab="courses"
                                    class="profile-tab flex-1 px-6 py-4 text-sm font-bold border-b-2 border-gray-900 text-gray-900 hover:bg-gray-50 transition">
                                    Courses
                                </button>
                                <button onclick="switchTab('certificates')" data-tab="certificates"
                                    class="profile-tab flex-1 px-6 py-4 text-sm font-bold border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition">
                                    Certificates
                                </button>
                            </div>
                        </div>

                        {{-- Tab Content --}}
                        <div class="p-6">

                            {{-- Courses Tab --}}
                            <div id="courses-tab" class="profile-tab-content">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-bold text-gray-900">
                                        Enrolled Courses ({{ $enrolledCourses->count() }})
                                    </h3>
                                </div>

                                @if ($enrolledCourses->count() > 0)
                                    <div class="space-y-4">
                                        @foreach ($enrolledCourses as $enrollment)
                                            @php
                                                $course = $enrollment->course;
                                                $progress = $enrollment->progress ?? 0;
                                            @endphp

                                            <div
                                                class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:shadow-md transition">
                                                {{-- Thumbnail --}}
                                                <a href="{{ route('courses.show', $course->slug) }}" class="shrink-0">
                                                    <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: 'https://placehold.co/200x112/667eea/white?text=Course' }}"
                                                        alt="{{ $course->title }}" class="w-40 h-24 object-cover rounded">
                                                </a>

                                                {{-- Course Info --}}
                                                <div class="flex-1 min-w-0">
                                                    <a href="{{ route('courses.show', $course->slug) }}" class="block">
                                                        <h4
                                                            class="font-bold text-gray-900 hover:text-purple-600 transition line-clamp-2 mb-2">
                                                            {{ $course->title }}
                                                        </h4>
                                                    </a>

                                                    <p class="text-sm text-gray-600 mb-3">
                                                        By {{ $course->instructor->name }}
                                                    </p>

                                                    {{-- Progress Bar --}}
                                                    <div class="mb-2">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-xs font-semibold text-gray-700">
                                                                {{ $progress }}% complete
                                                            </span>
                                                            @if ($progress >= 100)
                                                                <span
                                                                    class="text-xs font-semibold text-green-600 flex items-center gap-1">
                                                                    <i class="fa fa-check-circle"></i>
                                                                    Completed
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                                            <div class="h-full bg-purple-600 transition-all duration-300"
                                                                style="width: {{ $progress }}%"></div>
                                                        </div>
                                                    </div>

                                                    {{-- Action Button --}}
                                                    <div class="flex items-center gap-3">
                                                        @if ($progress < 100)
                                                            <a href="{{ route('course.learn', $course->slug) }}"
                                                                class="text-sm font-bold text-purple-600 hover:text-purple-700">
                                                                {{ $progress > 0 ? 'Continue learning' : 'Start course' }}
                                                                →
                                                            </a>
                                                        @else
                                                            <a href="{{ route('course.learn', $course->slug) }}"
                                                                class="text-sm font-bold text-purple-600 hover:text-purple-700">
                                                                Review course →
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-16">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa fa-book-open text-3xl text-gray-400"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">No courses yet</h4>
                                        <p class="text-gray-600 mb-6">Start learning by enrolling in courses</p>
                                        <a href="{{ route('courses.search') }}"
                                            class="inline-block px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded transition">
                                            Browse Courses
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Reviews Tab --}}


                            {{-- Certificates Tab --}}
                            <div id="certificates-tab" class="profile-tab-content hidden">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">
                                    Certificates ({{ $myCertificates->count() }})
                                </h3>

                                @if ($myCertificates->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($myCertificates as $certificate)
                                            <div
                                                class="relative group border-2 border-gray-200 rounded-lg overflow-hidden hover:border-purple-400 transition">
                                                <div class="aspect-[4/3] bg-gradient-to-br from-purple-50 to-pink-50 p-6">
                                                    <div class="h-full flex flex-col justify-between">
                                                        <div>
                                                            <div
                                                                class="inline-block px-3 py-1 bg-white rounded-full text-xs font-semibold text-purple-600 mb-3">
                                                                <i class="fa fa-certificate"></i> Certificate
                                                            </div>
                                                            <h4 class="font-bold text-gray-900 line-clamp-2">
                                                                {{ $certificate->course->title }}
                                                            </h4>
                                                        </div>
                                                        <div class="text-xs text-gray-600">
                                                            Completed {{ $certificate->created_at->format('M d, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                    <a href="{{ route('certificate.download', $certificate->id) }}"
                                                        class="px-4 py-2 bg-white text-gray-900 font-semibold rounded hover:bg-gray-100 transition">
                                                        <i class="fa fa-download mr-2"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-16">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa fa-certificate text-3xl text-gray-400"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">No certificates yet</h4>
                                        <p class="text-gray-600">Complete courses to earn certificates</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchTab(tabName) {
                // Hide all tab contents
                document.querySelectorAll('.profile-tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active state from all tabs
                document.querySelectorAll('.profile-tab').forEach(tab => {
                    tab.classList.remove('border-gray-900', 'text-gray-900');
                    tab.classList.add('border-transparent', 'text-gray-600');
                });

                // Show selected tab content
                document.getElementById(tabName + '-tab').classList.remove('hidden');

                // Add active state to clicked tab
                const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
                activeTab.classList.add('border-gray-900', 'text-gray-900');
                activeTab.classList.remove('border-transparent', 'text-gray-600');
            }

            function uploadAvatar(input) {
                if (input.files && input.files[0]) {
                    const formData = new FormData();
                    formData.append('avatar', input.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('#', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            }
                        });
                }
            }
        </script>
    @endpush
@endsection
