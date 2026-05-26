@extends('frontend.pages.instructor.layout')
@section('title', 'Reviews - Instructor Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="font-sora text-2xl sm:text-3xl font-extrabold text-gray-900">Course Reviews</h1>
                        <p class="text-sm text-gray-600 mt-1">Manage and approve student reviews</p>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="flex items-center gap-2 text-sm flex-wrap">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg font-semibold">
                            Total: {{ $reviews->total() }}
                        </span>
                        @if ($pendingCount > 0)
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-semibold">
                                Pending: {{ $pendingCount }}
                            </span>
                        @endif
                        @if ($approvedCount > 0)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg font-semibold">
                                Approved: {{ $approvedCount }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Filters --}}
                <form method="GET" action="{{ route('instructor.reviews.index') }}" class="mt-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Course Filter --}}
                        <select name="course_id" onchange="this.form.submit()"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-purple-500 cursor-pointer bg-white text-sm">
                            <option value="">All Courses</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ Str::limit($course->title, 40) }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Status Filter --}}
                        <div class="flex gap-2 bg-gray-100 p-1 rounded-lg">
                            <a href="{{ route('instructor.reviews.index', request()->except('status')) }}"
                                class="px-4 py-2 rounded-md text-sm font-semibold transition {{ !request('status') ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                All
                            </a>
                            <a href="{{ route('instructor.reviews.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-md text-sm font-semibold transition {{ request('status') === 'pending' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Pending
                                @if ($pendingCount > 0)
                                    <span
                                        class="px-1.5 py-0.5 bg-amber-500 text-white text-xs font-bold rounded-full">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('instructor.reviews.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}"
                                class="px-4 py-2 rounded-md text-sm font-semibold transition {{ request('status') === 'approved' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Approved
                            </a>
                            <a href="{{ route('instructor.reviews.index', array_merge(request()->except('status'), ['status' => 'rejected'])) }}"
                                class="px-4 py-2 rounded-md text-sm font-semibold transition {{ request('status') === 'rejected' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Rejected
                            </a>
                        </div>

                        {{-- Rating Filter --}}
                        <select name="rating" onchange="this.form.submit()"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-purple-500 cursor-pointer bg-white text-sm">
                            <option value="">All Ratings</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} ⭐ {{ $i == 1 ? 'Star' : 'Stars' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </form>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    <p class="text-sm font-semibold text-red-900">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Reviews List --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            @forelse($reviews as $review)
                <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6 mb-4 hover:shadow-md transition">

                    {{-- Review Header --}}
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            {{-- User Avatar --}}
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm sm:text-base shrink-0">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>

                            {{-- User Info & Course --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-sm sm:text-base text-gray-900">
                                    {{ $review->user->name ?? 'Unknown User' }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600 mb-1">
                                    {{ $review->created_at->format('M d, Y \a\t g:i A') }}</p>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span
                                        class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-lg line-clamp-1">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        {{ Str::limit($review->course->title ?? '—', 30) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex items-center gap-2">
                            @if ($review->status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Approved
                                </span>
                            @elseif($review->status === 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                                    <i class="fas fa-times-circle mr-1"></i>Rejected
                                </span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div class="flex items-center gap-1 mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i
                                class="fas fa-star text-lg {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}"></i>
                        @endfor
                        <span class="ml-2 text-sm font-semibold text-gray-700">{{ $review->rating }}.0</span>
                    </div>

                    {{-- Review Text --}}
                    <div class="mb-4">
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">{{ $review->review }}</p>
                    </div>

                    {{-- Action Buttons --}}
                    @if ($review->status === 'pending')
                        <div class="flex flex-col sm:flex-row gap-2">
                            <form action="{{ route('instructor.reviews.approve', $review->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-check"></i>
                                    <span>Approve Review</span>
                                </button>
                            </form>
                            <form action="{{ route('instructor.reviews.reject', $review->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to reject this review?')"
                                    class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-times"></i>
                                    <span>Reject Review</span>
                                </button>
                            </form>
                        </div>
                    @elseif($review->status === 'approved')
                        <div class="flex gap-2">
                            <form action="{{ route('instructor.reviews.reject', $review->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Unpublish this review?')"
                                    class="w-full px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition text-sm">
                                    <i class="fas fa-eye-slash mr-2"></i>Unpublish
                                </button>
                            </form>
                        </div>
                    @elseif($review->status === 'rejected')
                        <div class="flex gap-2">
                            <form action="{{ route('instructor.reviews.approve', $review->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-sm">
                                    <i class="fas fa-check mr-2"></i>Approve Now
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No reviews found</h3>
                    <p class="text-gray-600">
                        @if (request('status'))
                            No {{ request('status') }} reviews at the moment.
                        @else
                            Your courses haven't received any reviews yet.
                        @endif
                    </p>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($reviews->hasPages())
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
