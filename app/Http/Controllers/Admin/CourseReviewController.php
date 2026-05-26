<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseReviewRequest;
use App\Http\Requests\UpdateCourseReviewRequest;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\User;
use App\Services\CourseReviewService;

class CourseReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected readonly CourseReviewService $CourseReviewService) {}

    public function index()
    {
        $CourseReviews = CourseReview::latest()->paginate(20);

        return view('admin.course-reviews.index', compact('CourseReviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.course-reviews.create', compact('users', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseReviewRequest $request)
    {
        $data = $request->validated();

        $this->CourseReviewService->create($data);

        return to_route('admin.course-reviews.index')->with('status', 'Course Review Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseReview $CourseReview)
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.course-review.show', compact('users', 'course', 'CourseReview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseReview $CourseReview)
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.course-reviews.edit', compact('users', 'course', 'CourseReview'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseReviewRequest $request, CourseReview $CourseReview)
    {

        $data = $request->validated();

        $this->CourseReviewService->update($CourseReview, $data);

        return to_route('admin.course-reviews.index')->with('status', 'Course Review Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseReview $CourseReview)
    {
        $CourseReview->delete();
        // dd($CourseReview);

        return to_route('admin.course-reviews.index')->with('status', 'Course Review Deleted successfully!');
    }
}
