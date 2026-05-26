<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);

        return view('frontend.pages.review', compact('course'));
    }

    public function store(Request $request, $courseId)
    {
        $userId = auth()->id();

        $existingReview = CourseReview::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this course!');
        }

        CourseReview::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return to_route('index')->with('status', 'Course Review Successfully Created!');
    }
}
