@extends('frontend.layouts.app')
@section('title', 'Learn: ' . $course->title . ' - SkillNest')

@push('styles')
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent: #7c3aed;
            --accent-light: #8b5cf6;
            --accent-glow: rgba(124, 58, 237, 0.25);
            --surface: #111827;
            --surface-2: #1f2937;
            --surface-3: #374151;
            --border: rgba(255, 255, 255, 0.07);
            --text: #f9fafb;
            --text-muted: #9ca3af;
            --text-dim: #6b7280;
            --green: #10b981;
            --green-soft: rgba(16, 185, 129, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
        }

        h1,
        h2,
        h3,
        h4,
        .font-display {
            font-family: 'Sora', sans-serif;
        }

        /* ── Video Player ── */
        .video-js {
            width: 100%;
            height: 100%;
        }

        .vjs-big-play-button {
            border: none !important;
            background: var(--accent-glow) !important;
            backdrop-filter: blur(8px);
            width: 72px !important;
            height: 72px !important;
            border-radius: 50% !important;
            line-height: 72px !important;
            font-size: 28px !important;
            left: 50% !important;
            top: 50% !important;
            margin: 0 !important;
            transform: translate(-50%, -50%) !important;
            border: 2px solid rgba(139, 92, 246, 0.5) !important;
            transition: all 0.2s ease !important;
        }

        .vjs-big-play-button:hover {
            background: rgba(124, 58, 237, 0.7) !important;
            transform: translate(-50%, -50%) scale(1.1) !important;
        }

        .video-js .vjs-control-bar {
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.85));
            padding: 0 8px 4px;
            height: 42px;
        }

        .video-js .vjs-play-progress {
            background: var(--accent-light);
        }

        .video-js .vjs-slider {
            background: rgba(255, 255, 255, 0.15);
        }

        /* ── Topbar ── */
        .topbar {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        /* ── Sidebar ── */
        #curriculum-sidebar {
            background: var(--surface-2);
            border-left: 1px solid var(--border);
            scrollbar-width: thin;
            scrollbar-color: var(--surface-3) transparent;
        }

        #curriculum-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #curriculum-sidebar::-webkit-scrollbar-thumb {
            background: var(--surface-3);
            border-radius: 4px;
        }

        /* ── Progress Bar ── */
        .progress-bar-track {
            background: var(--surface-3);
            border-radius: 99px;
            overflow: hidden;
            height: 5px;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, var(--accent), #ec4899);
            border-radius: 99px;
            height: 100%;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Lesson Row ── */
        .lesson-row {
            transition: background 0.15s ease;
            border-left: 2px solid transparent;
        }

        .lesson-row:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .lesson-row.active {
            border-left-color: var(--accent-light);
            background: rgba(139, 92, 246, 0.08);
        }

        /* ── Section Toggle ── */
        .section-header {
            transition: background 0.15s ease;
        }

        .section-header:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .section-icon {
            transition: transform 0.25s ease;
        }

        .section-icon.open {
            transform: rotate(180deg);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--accent);
            color: #fff;
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 13px;
            padding: 9px 18px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #6d28d9;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px var(--accent-glow);
        }

        .btn-secondary {
            background: var(--surface-3);
            color: var(--text-muted);
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 500;
            font-size: 13px;
            padding: 9px 16px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #4b5563;
            color: var(--text);
        }

        .btn-complete {
            background: var(--green);
            color: #fff;
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 13px;
            padding: 9px 20px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-complete:hover {
            background: #059669;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
        }

        .btn-complete:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .badge-completed {
            background: var(--green-soft);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: var(--green);
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 13px;
            padding: 9px 18px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        /* ── Discussion ── */
        .discussion-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            transition: border-color 0.2s ease;
        }

        .discussion-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
        }

        .reply-bubble {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
        }

        .input-field {
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            outline: none;
            resize: none;
        }

        .input-field::placeholder {
            color: var(--text-dim);
        }

        .input-field:focus {
            border-color: var(--accent-light);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        /* ── Divider ── */
        .divider {
            border-color: var(--border);
        }

        /* ── Lesson Info ── */
        .lesson-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-dim);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 3px 10px;
        }

        /* ── Backdrop ── */
        #sidebar-backdrop {
            backdrop-filter: blur(4px);
        }

        /* ── Cert Button ── */
        .btn-cert {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 13px;
            padding: 9px 16px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.25);
        }

        .btn-cert:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4);
        }

        /* ── Empty video ── */
        .video-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--text-dim);
            height: 100%;
        }

        .video-empty i {
            font-size: 52px;
            opacity: 0.3;
        }

        .video-empty p {
            font-size: 14px;
        }

        /* ── Prose ── */
        .prose-custom {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 14px;
        }

        .prose-custom p {
            margin-bottom: 10px;
        }

        .prose-custom a {
            color: var(--accent-light);
        }
    </style>
@endpush

@section('content')
    <div style="background:var(--surface);">

        {{-- ── Top Navigation Bar ── --}}
        <div class="topbar sticky top-0 z-50">
            <div style="max-width:2000px; margin:0 auto; padding:0 16px;">
                <div style="display:flex; align-items:center; justify-content:space-between; height:56px;">

                    {{-- Left --}}
                    <div style="display:flex; align-items:center; gap:12px; flex:1; min-width:0;">
                        <a href="{{ route('my-learning.index') }}"
                            style="color:var(--text-muted); transition:color 0.15s; display:flex; align-items:center; padding:6px; border-radius:6px;"
                            onmouseover="this.style.color='var(--text)';this.style.background='var(--surface-3)'"
                            onmouseout="this.style.color='var(--text-muted)';this.style.background='transparent'">
                            <i class="fas fa-arrow-left" style="font-size:13px;"></i>
                        </a>
                        <div style="min-width:0; flex:1;">
                            <h1
                                style="color:var(--text); font-family:'Sora',sans-serif; font-weight:600; font-size:14px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin:0;">
                                {{ $course->title }}</h1>
                        </div>
                    </div>

                    {{-- Right --}}
                    <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                        @if ($progressPercentage == 100)
                            <a href="{{ route('certificate.show', $course->slug) }}" class="btn-cert">
                                <i class="fas fa-award"></i>
                                <span>Certificate</span>
                            </a>
                        @endif
                        <a href="{{ route('reviews.index', $course->id) }}" class="btn-primary">
                            <span>Leave a Review</span>
                            <i class="fas fa-star" style="font-size:11px;"></i>
                        </a>
                        <button onclick="toggleSidebar()"
                            style="display:none; background:none; border:none; color:var(--text-muted); cursor:pointer; padding:6px; border-radius:6px;"
                            class="sidebar-toggle-btn" onmouseover="this.style.color='var(--text)'"
                            onmouseout="this.style.color='var(--text-muted)'">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Body Layout ── --}}
        <div style="display:flex; max-width:2000px; margin:0 auto;">

            {{-- ── Main Content ── --}}
            <div style="flex:1; min-width:0;">

                {{-- Video Player --}}
                <div style="background:#000; aspect-ratio:16/9; position:relative;">
                    @if ($currentLesson->getFirstMediaUrl('video'))
                        <video id="course-video" class="video-js vjs-big-play-centered" controls preload="auto"
                            data-lesson-id="{{ $currentLesson->id }}" data-setup='{}'>
                            <source src="{{ $currentLesson->getFirstMediaUrl('video') }}" type="video/mp4">
                        </video>
                    @else
                        <div class="video-empty" style="height:100%;">
                            <i class="fas fa-video"></i>
                            <p>No video available for this lesson</p>
                        </div>
                    @endif
                </div>

                {{-- ── Lesson Info Panel ── --}}
                <div style="background:var(--surface-2); padding:24px; border-bottom:1px solid var(--border);">

                    {{-- Header row --}}
                    <div
                        style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:16px; flex-wrap:wrap;">
                        <div style="flex:1; min-width:0;">
                            <h2
                                style="font-family:'Sora',sans-serif; font-size:20px; font-weight:700; color:var(--text); margin:0 0 8px;">
                                {{ $currentLesson->title }}</h2>
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <span class="lesson-meta-chip">
                                    <i class="fas fa-play-circle"></i>
                                    Lesson {{ $currentLesson->order }} of {{ $totalLessons }}
                                </span>
                                {{ $currentLesson->formattedDuration }}
                            </div>
                        </div>

                        {{-- Complete Button --}}
                        @if (!$lessonProgress || !$lessonProgress->is_completed)
                            <button onclick="markComplete()" id="complete-btn" class="btn-complete">
                                <i class="fas fa-check-circle"></i>
                                <span>Mark Complete</span>
                            </button>
                        @else
                            <div class="badge-completed">
                                <i class="fas fa-check-circle"></i>
                                <span>Completed</span>
                            </div>
                        @endif
                    </div>

                    {{-- Nav Buttons --}}
                    <div style="display:flex; align-items:center; gap:8px;">
                        @if ($previousLesson)
                            <a href="{{ route('course.learn.lesson', [$course->slug, $previousLesson->id]) }}"
                                class="btn-secondary">
                                <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                                <span>Previous</span>
                            </a>
                        @endif
                        @if ($nextLesson)
                            <a href="{{ route('course.learn.lesson', [$course->slug, $nextLesson->id]) }}"
                                class="btn-primary">
                                <span>Next Lesson</span>
                                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                            </a>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if ($currentLesson->content)
                        <div style="margin-top:24px; padding-top:24px; border-top:1px solid var(--border);">
                            <p
                                style="font-family:'Sora',sans-serif; font-size:11px; font-weight:600; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.08em; margin:0 0 12px;">
                                About This Lesson</p>
                            <div class="prose-custom">
                                {!! $currentLesson->content !!}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── Discussion Section ── --}}
                <div style="background:var(--surface-2); padding:24px 24px 32px; border-top:1px solid var(--border);">

                    <h3
                        style="font-family:'Sora',sans-serif; font-size:17px; font-weight:700; color:var(--text); margin:0 0 20px; display:flex; align-items:center; gap:8px;">
                        <span
                            style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:var(--accent-glow); border-radius:6px; color:var(--accent-light); font-size:12px;">
                            <i class="fas fa-comments"></i>
                        </span>
                        Lesson Discussion
                    </h3>

                    {{-- Post form --}}
                    <form action="{{ route('discussion.store') }}" method="POST" style="margin-bottom:24px;">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="lesson_id" value="{{ $currentLesson->id }}">
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <input type="text" name="title" placeholder="What's your question about this lesson?"
                                class="input-field">
                            <textarea name="message" rows="3"
                                placeholder="Give us more detail — the more specific, the better the answers you'll get." class="input-field"></textarea>
                            <div>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-paper-plane" style="font-size:11px;"></i>
                                    Post Question
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Discussions list --}}
                    @forelse($discussions as $discussion)
                        <div class="discussion-card">
                            <h4
                                style="font-family:'Sora',sans-serif; font-size:14px; font-weight:600; color:var(--text); margin:0 0 6px;">
                                {{ $discussion->title }}</h4>
                            <p style="color:var(--text-muted); font-size:13px; line-height:1.6; margin:0 0 8px;">
                                {{ $discussion->message }}</p>
                            <p style="font-size:11px; color:var(--text-dim); margin:0 0 12px;">
                                <i class="fas fa-user-circle" style="margin-right:4px;"></i>{{ $discussion->user->name }}
                            </p>

                            {{-- Replies --}}
                            @if ($discussion->replies->count())
                                <div
                                    style="display:flex; flex-direction:column; gap:6px; margin-bottom:12px; padding-left:12px; border-left:2px solid var(--surface-3);">
                                    @foreach ($discussion->replies as $reply)
                                        <div class="reply-bubble">
                                            <span
                                                style="font-weight:600; color:var(--text); font-size:12px;">{{ $reply->user->name }}</span>
                                            <span style="color:var(--text-muted);"> · {{ $reply->message }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Reply form --}}
                            <form action="{{ route('discussion.index') }}" method="POST"
                                style="display:flex; gap:8px;">
                                @csrf
                                <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
                                <input type="text" name="message" placeholder="Write a reply..." class="input-field"
                                    style="flex:1; padding:8px 12px; font-size:13px;">
                                <button type="submit" class="btn-primary"
                                    style="padding:8px 14px; flex-shrink:0; font-size:12px;">
                                    <i class="fas fa-reply" style="font-size:10px;"></i>
                                    Reply
                                </button>
                            </form>
                        </div>
                    @empty
                        <div style="text-align:center; padding:32px 16px; color:var(--text-dim);">
                            <i class="fas fa-comment-slash"
                                style="font-size:28px; margin-bottom:8px; opacity:0.4; display:block;"></i>
                            <p style="font-size:13px; margin:0;">No questions yet. Be the first to ask!</p>
                        </div>
                    @endforelse

                </div>

            </div>

            {{-- ── Curriculum Sidebar ── --}}
            <div id="curriculum-sidebar"
                style="width:340px; flex-shrink:0; overflow-y:auto; position:sticky; top:56px; height:calc(100vh - 56px); z-index:40;">

                {{-- Sticky header --}}
                <div
                    style="position:sticky; top:0; background:var(--surface-2); border-bottom:1px solid var(--border); padding:16px; z-index:10;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                        <h3
                            style="font-family:'Sora',sans-serif; font-size:14px; font-weight:700; color:var(--text); margin:0;">
                            Course Content</h3>
                        <button onclick="toggleSidebar()" class="sidebar-close-btn"
                            style="display:none; background:none; border:none; color:var(--text-muted); cursor:pointer; padding:4px; border-radius:4px; font-size:14px;"
                            onmouseover="this.style.color='var(--text)'"
                            onmouseout="this.style.color='var(--text-muted)'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    {{-- Progress --}}
                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                            <span style="font-size:11px; color:var(--text-dim);">Your progress</span>
                            <span
                                style="font-size:11px; font-weight:600; color:var(--accent-light); font-family:'Sora',sans-serif;">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width:{{ $progressPercentage }}%;"></div>
                        </div>
                        <p style="font-size:11px; color:var(--text-dim); margin-top:5px;">{{ $completedLessons }} /
                            {{ $totalLessons }} lessons completed</p>
                    </div>
                </div>

                {{-- Sections --}}
                <div style="padding:10px 8px; display:flex; flex-direction:column; gap:4px;">
                    @foreach ($course->sections()->get() as $section)
                        <div
                            style="background:var(--surface); border-radius:10px; overflow:hidden; border:1px solid var(--border);">
                            <button onclick="toggleSection({{ $section->id }})" class="section-header"
                                style="width:100%; display:flex; align-items:center; justify-content:space-between; padding:12px 14px; background:none; border:none; cursor:pointer; text-align:left;">
                                <div style="flex:1; min-width:0;">
                                    <h4
                                        style="font-family:'Sora',sans-serif; font-size:13px; font-weight:600; color:var(--text); margin:0 0 2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $section->title }}</h4>
                                    <p style="font-size:11px; color:var(--text-dim); margin:0;">
                                        {{ $section->lessons->count() }} lessons</p>
                                </div>
                                <i class="fas fa-chevron-down section-icon" id="section-icon-{{ $section->id }}"
                                    style="color:var(--text-dim); font-size:10px; margin-left:8px; flex-shrink:0;"></i>
                            </button>

                            <div id="section-{{ $section->id }}" style="display:none;">
                                @foreach ($section->lessons()->orderBy('order')->get() as $lesson)
                                    @php
                                        $lessonCompleted = $userProgress->where('lesson_id', $lesson->id)->first();
                                        $isCompleted = $lessonCompleted && $lessonCompleted->is_completed;
                                        $isCurrent = $lesson->id === $currentLesson->id;
                                    @endphp
                                    <a href="{{ route('course.learn.lesson', [$course->slug, $lesson->id]) }}"
                                        class="lesson-row {{ $isCurrent ? 'active' : '' }}"
                                        style="display:flex; align-items:center; gap:10px; padding:10px 14px; text-decoration:none;">
                                        <div
                                            style="width:18px; height:18px; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                            @if ($isCompleted)
                                                <i class="fas fa-check-circle"
                                                    style="color:var(--green); font-size:13px;"></i>
                                            @elseif($isCurrent)
                                                <i class="fas fa-play-circle"
                                                    style="color:var(--accent-light); font-size:13px;"></i>
                                            @else
                                                <i class="far fa-circle"
                                                    style="color:var(--text-dim); font-size:12px;"></i>
                                            @endif
                                        </div>
                                        <div style="flex:1; min-width:0;">
                                            <p
                                                style="font-size:12px; color:{{ $isCurrent ? 'var(--text)' : 'var(--text-muted)' }}; font-weight:{{ $isCurrent ? '600' : '400' }}; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family:{{ $isCurrent ? "'Sora',sans-serif" : 'inherit' }};">
                                                {{ $lesson->title }}</p>
                                            @if ($lesson->duration)
                                                <p style="font-size:10px; color:var(--text-dim); margin:2px 0 0;">
                                                    {{ $lesson->formatted_duration }}</p>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- Mobile backdrop --}}
    <div id="sidebar-backdrop" onclick="toggleSidebar()"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:30; backdrop-filter:blur(4px);">
    </div>

    @push('scripts')
        <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
        <script>
            // ── Responsive: show/hide mobile sidebar toggle ──
            function handleResize() {
                const toggleBtns = document.querySelectorAll('.sidebar-toggle-btn');
                const closeBtns = document.querySelectorAll('.sidebar-close-btn');
                const sidebar = document.getElementById('curriculum-sidebar');
                const isMobile = window.innerWidth < 1024;

                toggleBtns.forEach(b => b.style.display = isMobile ? 'block' : 'none');

                if (isMobile) {
                    sidebar.style.position = 'fixed';
                    sidebar.style.top = '56px';
                    sidebar.style.right = '0';
                    sidebar.style.height = 'calc(100vh - 56px)';
                    sidebar.style.zIndex = '40';
                    closeBtns.forEach(b => b.style.display = 'block');
                    if (!sidebar.dataset.mobileInit) {
                        sidebar.style.transform = 'translateX(100%)';
                        sidebar.style.transition = 'transform 0.3s cubic-bezier(0.4,0,0.2,1)';
                        sidebar.dataset.mobileInit = '1';
                    }
                } else {
                    sidebar.style.position = 'sticky';
                    sidebar.style.transform = 'translateX(0)';
                    sidebar.style.transition = '';
                    closeBtns.forEach(b => b.style.display = 'none');
                    sidebar.dataset.mobileInit = '';
                    document.getElementById('sidebar-backdrop').style.display = 'none';
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize();

            // ── Sidebar Toggle (mobile) ──
            function toggleSidebar() {
                const sidebar = document.getElementById('curriculum-sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                const isOpen = sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0)';
                sidebar.style.transform = isOpen ? 'translateX(100%)' : 'translateX(0)';
                backdrop.style.display = isOpen ? 'none' : 'block';
            }

            // ── Section Toggle ──
            function toggleSection(sectionId) {
                const section = document.getElementById('section-' + sectionId);
                const icon = document.getElementById('section-icon-' + sectionId);
                const isHidden = section.style.display === 'none' || section.style.display === '';
                section.style.display = isHidden ? 'block' : 'none';
                icon.classList.toggle('open', isHidden);
            }

            // ── Auto-expand current section ──
            document.addEventListener('DOMContentLoaded', function() {
                const activeLesson = document.querySelector('.lesson-row.active');
                if (activeLesson) {
                    const sectionEl = activeLesson.closest('[id^="section-"]');
                    if (sectionEl) {
                        sectionEl.style.display = 'block';
                        const sectionId = sectionEl.id.replace('section-', '');
                        const icon = document.getElementById('section-icon-' + sectionId);
                        if (icon) icon.classList.add('open');
                    }
                }
            });

            // ── Video.js Init ──
            let player;
            document.addEventListener('DOMContentLoaded', function() {
                const videoElement = document.getElementById('course-video');
                if (!videoElement) return;

                player = videojs('course-video', {
                    controls: true,
                    autoplay: false,
                    preload: 'auto',
                    fluid: false,
                    aspectRatio: '16:9',
                    playbackRates: [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
                    controlBar: {
                        children: [
                            'playToggle',
                            'progressControl',
                            'currentTimeDisplay',
                            'timeDivider',
                            'durationDisplay',
                            'volumePanel',
                            'playbackRateMenuButton',
                            'pictureInPictureToggle',
                            'fullscreenToggle'
                        ]
                    }
                });

                player.on('timeupdate', function() {
                    const t = Math.floor(player.currentTime());
                    if (t > 0 && t % 5 === 0) updateProgress(t);
                });

                player.on('ended', function() {
                    @if (!$lessonProgress || !$lessonProgress->is_completed)
                        markComplete();
                    @endif
                });

                @if ($lessonProgress && $lessonProgress->watched_seconds)
                    player.ready(function() {
                        const saved = {{ $lessonProgress->watched_seconds }};
                        if (saved > 10) player.currentTime(saved);
                    });
                @endif
            });

            // ── Progress ──
            function updateProgress(seconds) {
                fetch('{{ route('lesson.progress', $currentLesson->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        watched_seconds: seconds
                    })
                }).catch(e => console.error('Progress error:', e));
            }

            // ── Mark Complete ──
            function markComplete() {
                const btn = document.getElementById('complete-btn');
                if (!btn || btn.disabled) return;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Completing…';

                fetch('{{ route('lesson.complete', $currentLesson->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            btn.className = 'badge-completed';
                            btn.innerHTML = '<i class="fas fa-check-circle"></i><span>Completed</span>';
                            setTimeout(() => location.reload(), 900);
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-check-circle"></i><span>Mark Complete</span>';
                    });
            }
        </script>
    @endpush
@endsection
