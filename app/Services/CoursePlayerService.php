<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Discussion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Notifications\CourseCompletedNotification;
use Illuminate\Support\Facades\Auth;

class CoursePlayerService
{
    public function create($courseSlug, $lessonId = null)
    {
        $course = Course::where('slug', $courseSlug)
            ->with(['sections.lessons', 'instructor'])
            ->firstOrFail();

        $enrollment = $course->enrollments()
            ->where('user_id', Auth::id())
            ->first();

        if (! $enrollment) {
            return [
                'error' => true,
                'redirect' => route('course.show', $courseSlug),
                'message' => 'Please enroll in this course first.',
            ];
        }

        $allLessons = collect();

        foreach ($course->sections as $section) {
            $allLessons = $allLessons->merge(
                $section->lessons->sortBy('order')
            );
        }

        if ($allLessons->isEmpty()) {
            return [
                'error' => true,
                'message' => 'No lessons found in this course.',
            ];
        }

        if ($lessonId) {
            $currentLesson = Lesson::findOrFail($lessonId);
        } else {
            $currentLesson = $allLessons->first();

            return [
                'redirect_lesson' => true,
                'lesson_id' => $currentLesson->id,
            ];
        }

        $currentIndex = $allLessons->search(
            fn ($lesson) => $lesson->id === $currentLesson->id
        );

        $previousLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;

        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        $userProgress = LessonProgress::where('user_id', Auth::id())->whereIn('lesson_id', $allLessons->pluck('id'))->get();

        $lessonProgress = $userProgress->where('lesson_id', $currentLesson->id)->first();

        $totalLessons = $allLessons->count();

        $completedLessons = $userProgress->where('is_completed', true)->count();

        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        CourseProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $course->id,
            ],
            [
                'is_completed' => 0,
            ]
        );

        $discussions = Discussion::with(['user', 'replies.user'])->where('lesson_id', $currentLesson->id)->latest()->get();

        return compact(
            'enrollment',
            'course',
            'currentLesson',
            'previousLesson',
            'nextLesson',
            'userProgress',
            'lessonProgress',
            'totalLessons',
            'completedLessons',
            'progressPercentage',
            'discussions'
        );
    }

    public function markLessonComplete($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lessonId,
            ],
            [
                'is_completed' => 1,
                'completed_at' => now(),
            ]
        );

        $courseId = $lesson->section->course_id;

        $totalLessons = Lesson::whereHas('section', function ($q) use ($courseId) {
            $q->where('course_id', $courseId);
        })->count();

        $completedLessons = LessonProgress::where('user_id', Auth::id())
            ->where('is_completed', 1)
            ->whereHas('lesson.section', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })
            ->count();

        Enrollment::where('course_id', $courseId)->update([
            'progress_percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
        ]);

        if ($totalLessons == $completedLessons) {

            CourseProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $courseId,
                ],
                [
                    'is_completed' => 1,
                    'completed_at' => now(),
                ]
            );

            Certificate::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $courseId,
                ],
                [
                    'issued_at' => now(),
                ]
            );
            Auth::user()->notify(new CourseCompletedNotification($lesson->section->course));
        }

        return true;
    }

    public function updateLessonProgress($lessonId, $seconds)
    {
        LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lessonId,
            ],
            [
                'watched_seconds' => $seconds,
            ]
        );

        return true;
    }
}
