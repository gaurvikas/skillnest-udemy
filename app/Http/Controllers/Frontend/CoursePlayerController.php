<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CoursePlayerService;
use Illuminate\Http\Request;

class CoursePlayerController extends Controller
{
    public function __construct(protected readonly CoursePlayerService $coursePlayerService) {}

    public function learn($courseSlug, $lessonId = null)
    {
        $data = $this->coursePlayerService->create($courseSlug, $lessonId);

        if (isset($data['error']) && $data['error'] == true) {
            return back()->with('error', $data['message']);
        }

        if (isset($data['redirect_lesson'])) {
            return to_route('course.learn.lesson', [
                $courseSlug,
                $data['lesson_id'],
            ]);
        }

        return view('frontend.pages.course-player', $data);
    }

    public function markComplete($lessonId)
    {
        $this->coursePlayerService->markLessonComplete($lessonId);

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as complete!',
        ]);
    }

    public function updateProgress($lessonId, Request $request)
    {
        $request->validate([
            'watched_seconds' => 'required|integer|min:0',
        ]);

        $this->coursePlayerService->updateLessonProgress($lessonId, $request->watched_seconds);

        return response()->json(['success' => true]);
    }
}
