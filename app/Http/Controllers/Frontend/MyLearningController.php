<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;

class MyLearningController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $enrollments = Enrollment::where('user_id', $user->id)->with('course.instructor', 'course.media', 'course.sections.lessons')->latest()->get();

        foreach ($enrollments as $enrollment) {

            $course = $enrollment->course;

            $totalLessons = Lesson::whereHas('section', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })->count();

            $completedLessons = LessonProgress::where('user_id', $user->id)
                ->where('is_completed', 1)
                ->whereHas('lesson.section', function ($q) use ($course) {
                    $q->where('course_id', $course->id);
                })->count();

            $enrollment->completedLessons = $completedLessons;
            $enrollment->totalLessons = $totalLessons;
        }

        $completedCoursesCount = $user->courseProgress()->where('is_completed', true)->count();
        $incompleteCoursesCount = $enrollments->filter(function ($enrollment) {
            return $enrollment->progress_percentage > 0 && $enrollment->progress_percentage < 100;
        })->count();

        $certificates = $completedCoursesCount;

        $myCertificates = Certificate::with('course.instructor')->where('user_id', $user->id)->latest()->take(3)->get();

        return view('frontend.pages.my-learning', compact('enrollments', 'user', 'completedCoursesCount', 'incompleteCoursesCount', 'certificates', 'myCertificates'));
    }
}
