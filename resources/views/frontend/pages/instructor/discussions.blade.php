@extends('frontend.pages.instructor.layout')
@section('title', 'Discussions - Instructor Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Discussions</h1>
                        <p class="text-sm text-gray-600 mt-1">Review and respond to student questions</p>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="flex items-center gap-2 text-sm">
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg font-semibold">
                            Total: {{ $discussions->total() }}
                        </span>

                        @if ($unansweredCount > 0)
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-semibold">
                                Unanswered: {{ $unansweredCount }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Filters --}}
                <form method="GET" action="{{ route('discussion.index') }}">
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Search --}}
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search questions..."
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                            </div>
                        </div>

                        {{-- Course Filter --}}
                        <select name="course_id" onchange="this.form.submit()"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg outline-none focus:border-purple-500 cursor-pointer bg-white">
                            <option value="">All Courses</option>
                            @foreach ($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                    {{ Str::limit($c->title, 35) }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Status Tabs --}}
                        <div class="flex gap-2 bg-gray-100 p-1 rounded-lg">
                            <a href="{{ route('discussion.index', request()->except('filter')) }}"
                                class="px-4 py-2 rounded-md text-sm font-semibold transition {{ !request('filter') ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                All
                            </a>
                            <a href="{{ route('discussion.index', array_merge(request()->except('filter'), ['filter' => 'unanswered'])) }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-md text-sm font-semibold transition {{ request('filter') === 'unanswered' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Unanswered
                                @if ($unansweredCount > 0)
                                    <span
                                        class="px-1.5 py-0.5 bg-amber-500 text-white text-xs font-bold rounded-full">{{ $unansweredCount }}</span>
                                @endif
                            </a>
                        </div>

                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4  py-1.5 rounded text-sm transition text-center">
                            <i class="fas fa-filter mr-2"></i>Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex gap-6">

                {{-- Questions List (Left) --}}
                <div class="w-full lg:w-2/5 bg-white rounded-xl border border-gray-200 flex flex-col overflow-hidden">
                    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 px-4 py-3 z-10">
                        <h2 class="font-bold text-gray-900 text-sm">
                            Questions ({{ $discussions->total() }})
                        </h2>
                    </div>

                    <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
                        @forelse($discussions as $discussion)
                            @php $isAnswered = $discussion->replies->count() > 0; @endphp

                            <div class="disc-item p-4 cursor-pointer hover:bg-gray-50 transition-all {{ !$isAnswered ? 'bg-purple-50/30' : '' }}"
                                data-id="{{ $discussion->id }}" onclick="showDiscussion({{ $discussion->id }})">

                                {{-- Unread Indicator --}}
                                @if (!$isAnswered)
                                    <div class="absolute left-0 top-4 w-1 h-12 bg-purple-600 rounded-r"></div>
                                @endif

                                <div class="flex items-start gap-3 mb-3">

                                    <div
                                        class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                        {{ Auth::user()->initials() }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-sm text-gray-900 mb-1 line-clamp-2">
                                            {{ $discussion->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                                            {{ $discussion->message }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 flex-wrap text-xs">
                                    <span
                                        class="px-2 py-1 bg-white border border-gray-200 text-gray-700 rounded font-medium">
                                        {{ Str::limit($discussion->course->title ?? '—', 18) }}
                                    </span>
                                    @if (!$isAnswered)
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded font-semibold">
                                            <i class="fas fa-clock mr-1"></i>Unanswered
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded font-semibold">
                                            <i class="fas fa-check mr-1"></i>Answered
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 flex items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-user mr-1"></i>{{ $discussion->user->name ?? 'Unknown' }}</span>
                                    <span><i class="fas fa-reply mr-1"></i>{{ $discussion->replies->count() }}</span>
                                    <span class="ml-auto">{{ $discussion->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-20 px-8 text-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900 mb-2">No questions found</h3>
                                <p class="text-sm text-gray-600">No student questions match your filters</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($discussions->hasPages())
                        <div class="border-t border-gray-200 p-4">
                            {{ $discussions->links() }}
                        </div>
                    @endif
                </div>

                {{-- Question Detail (Right) --}}
                <div class="hidden lg:flex w-3/5 bg-white rounded-xl border border-gray-200 flex-col overflow-hidden">

                    {{-- Placeholder --}}
                    <div id="detail-placeholder" class="flex-1 flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-comments text-6xl mb-4 opacity-20"></i>
                        <p class="text-sm text-gray-500">Select a question to view details</p>
                    </div>

                    {{-- Detail Panels --}}
                    @foreach ($discussions as $discussion)
                        <div id="detail-{{ $discussion->id }}" class="hidden flex-col h-full">

                            {{-- Header --}}
                            <div class="border-b border-gray-200 p-6 bg-gray-50">
                                <div class="flex items-start gap-4 mb-4">
                                    <div
                                        class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                        {{ Auth::user()->initials() }}
                                    </div>

                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 mb-1">
                                            {{ $discussion->user->name ?? 'Unknown' }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $discussion->created_at->format('M d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900 mb-3">
                                    {{ $discussion->title }}
                                </h2>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    {{ $discussion->message }}
                                </p>

                                <div class="flex items-center gap-2 flex-wrap">
                                    <span
                                        class="px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-lg">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        {{ $discussion->course->title ?? '—' }}
                                    </span>
                                    @if ($discussion->lesson)
                                        <span
                                            class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg">
                                            <a href="{{ route('course.learn', $discussion->course->slug) }}"
                                                target="_blank"><i class="fas fa-play-circle mr-1"></i></a>
                                            {{ $discussion->lesson->title }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Replies --}}
                            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                                <h3 class="text-sm font-bold text-gray-900 mb-4">
                                    {{ $discussion->replies->count() }}
                                    {{ Str::plural('Reply', $discussion->replies->count()) }}
                                </h3>

                                @forelse($discussion->replies as $reply)
                                    @php $isInstructor = $reply->user_id === auth()->id(); @endphp

                                    <div class="flex gap-3">
                                        <div
                                            class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                            {{ Auth::user()->initials() }}
                                        </div>

                                        <div class="flex-1">
                                            <div
                                                class="rounded-2xl rounded-tl-none p-4 {{ $isInstructor ? 'bg-purple-50 border-2 border-purple-200' : 'bg-gray-50 border border-gray-200' }}">
                                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                    <span class="font-bold text-sm text-gray-900">
                                                        {{ $reply->user->name ?? 'Unknown' }}
                                                    </span>
                                                    @if ($isInstructor)
                                                        <span
                                                            class="px-2 py-0.5 bg-gray-600 text-white text-xs font-bold rounded">
                                                            INSTRUCTOR
                                                        </span>
                                                    @endif
                                                    <span class="text-xs text-gray-500 ml-auto">
                                                        {{ $reply->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($isInstructor)
                                                        <form action="{{ route('discussion.reply.destroy', $reply->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Delete this reply?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="text-gray-400 hover:text-red-600 transition ml-2">
                                                                <i class="fas fa-trash-alt text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-800 leading-relaxed">
                                                    {{ $reply->message }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 text-gray-400">
                                        <i class="fas fa-comment-dots text-4xl mb-3 opacity-20"></i>
                                        <p class="text-sm">No replies yet — be the first to respond!</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- Reply Form --}}
                            <div class="border-t border-gray-200 p-6 bg-gray-50">
                                <form action="{{ route('discussion.reply', $discussion->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">

                                    <div class="flex items-center gap-3 mb-3">
                                        <div
                                            class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold">
                                            {{ Auth::user()->initials() }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">
                                            Reply as Instructor
                                        </span>
                                    </div>

                                    <textarea name="message" rows="4" required placeholder="Write your response here..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition resize-none mb-4"></textarea>

                                    <div class="flex items-center gap-3">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded transition hover:-translate-y-px hover:shadow-md active:translate-y-0">
                                            <i class="fas fa-paper-plane text-xs"></i> Post Reply
                                        </button>
                                        <span class="text-xs text-gray-400">Student will be notified</span>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentId = null;

            function showDiscussion(id) {
                // Hide placeholder
                const placeholder = document.getElementById('detail-placeholder');
                if (placeholder) placeholder.classList.add('hidden');

                // Hide previous detail
                if (currentId !== null) {
                    const prev = document.getElementById('detail-' + currentId);
                    if (prev) prev.classList.add('hidden');

                    // Remove highlight
                    const prevItem = document.querySelector('.disc-item[data-id="' + currentId + '"]');
                    if (prevItem) {
                        prevItem.classList.remove('bg-purple-100', 'border-l-4', 'border-purple-600', 'shadow-sm');
                    }
                }

                // Show new detail
                const detail = document.getElementById('detail-' + id);
                if (detail) {
                    detail.classList.remove('hidden');
                    detail.classList.add('flex');
                }

                // Highlight active item
                const item = document.querySelector('.disc-item[data-id="' + id + '"]');
                if (item) {
                    item.classList.add('bg-purple-100', 'border-l-4', 'border-purple-600', 'shadow-sm');
                }

                currentId = id;

                // Mobile: Open modal or scroll
                if (window.innerWidth < 1024) {
                    // Add mobile detail view logic here if needed
                }
            }

            // Auto-open first discussion
            document.addEventListener('DOMContentLoaded', function() {
                const first = document.querySelector('.disc-item[data-id]');
                if (first) showDiscussion(parseInt(first.dataset.id));
            });
        </script>
    @endpush

@endsection
