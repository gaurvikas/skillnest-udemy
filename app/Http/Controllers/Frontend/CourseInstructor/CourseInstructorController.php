<?php

namespace App\Http\Controllers\Frontend\CourseInstructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\User;
use App\Services\CourseService;
use App\Services\SectionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseInstructorController extends Controller
{
    public function __construct(protected readonly CourseService $courseService, protected readonly SectionService $sectionService) {}

    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->withCount(['enrollments', 'reviews'])->with('media')->latest()->get();

        return view('frontend.pages.instructor.instructor', compact('courses'));
    }

    public function dashboard()
    {
        $instructorId = auth()->id();

        $totalStudents = Enrollment::whereHas('course', function ($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })->count();

        $totalCourses = Course::where('instructor_id', $instructorId)->count();

        $activeCourses = Course::where('instructor_id', $instructorId)->where('status', 'published')->count();

        $averageRating = Course::where('instructor_id', $instructorId)->with('reviews')->get()->flatMap(fn ($course) => $course->reviews)->avg('rating');

        // Instructor's course IDs
        $courseIds = Course::where('instructor_id', $instructorId)->pluck('id');

        // Recent Enrollments
        $enrollments = Enrollment::with(['user', 'course'])->whereIn('course_id', $courseIds)->latest()->take(5)->get();

        // Recent Discussions
        $discussions = Discussion::with(['user', 'course'])->whereIn('course_id', $courseIds)->latest()->take(5)->get();

        $reviews = Course::where('instructor_id', $instructorId)->with(['reviews.user'])->get()
            ->flatMap(function ($course) {

                return $course->reviews->map(function ($review) use ($course) {
                    $review->course = $course;

                    return $review;
                });
            });
        $totalRevenue = Order::query()
            ->where('orders.status', Order::STATUS_PAID)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('courses', 'order_items.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->sum('order_items.price');

        $instructorRevenue = round($totalRevenue * 0.80, 2);

        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) use ($instructorId) {
            $date = now()->subDays($daysAgo);
            $amount = Order::query()
                ->where('orders.status', Order::STATUS_PAID)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('courses', 'order_items.course_id', '=', 'courses.id')
                ->where('courses.instructor_id', $instructorId)
                ->whereDate('orders.paid_at', $date->toDateString())
                ->sum('order_items.price');

            return [
                'day' => $date->format('D'),
                'date' => $date->format('M d'),
                'amount' => round($amount * 0.80, 2),
            ];
        })->toArray();

        return view('frontend.pages.instructor.dashboard', compact(
            'totalCourses',
            'activeCourses',
            'totalStudents',
            'enrollments',
            'discussions',
            'reviews',
            'averageRating',
            'instructorRevenue',
            'revenueChart'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view('frontend.pages.instructor.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            DB::beginTransaction();

            $course = $this->courseService->create(
                $request,
                $request->validated()
            );

            // sync categories
            if ($request->filled('categories')) {
                $this->courseService->syncCategories(
                    $course,
                    $request->categories
                );
            }

            // create sections & lessons
            if ($request->filled('sections')) {

                foreach ($request->sections as $index => $sectionData) {

                    $section = $this->sectionService->create([
                        'course_id' => $course->id,
                        'title' => $sectionData['title'],
                        'order' => $index + 1,
                    ]);

                    if (! empty($sectionData['lessons'])) {

                        foreach ($sectionData['lessons'] as $lIndex => $lessonData) {

                            $lesson = Lesson::create([
                                'course_id' => $course->id,
                                'section_id' => $section->id,
                                'title' => $lessonData['title'],
                                'slug' => Str::slug($lessonData['title']).'-'.uniqid(),
                                'content' => $lessonData['content'] ?? null,
                                'duration' => $lessonData['duration'] ?? 0,
                                'order' => $lessonData['order'] ?? $lIndex + 1,
                                'is_preview' => $lessonData['is_preview'] ?? 0,
                            ]);

                            $fileKey = "sections.{$index}.lessons.{$lIndex}.video";

                            if ($request->hasFile($fileKey)) {
                                $lesson
                                    ->addMediaFromRequest($fileKey)
                                    ->toMediaCollection('video');
                            }
                        }
                    }
                }
            }

            DB::commit();

            return to_route('instructor.index')->with('success', 'Course created successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Course creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Failed to create course.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $users = User::pluck('name', key: 'id');
        $categories = Category::pluck('name', 'id');

        return view('frontend.pages.instructor.edit', compact('course', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            // update course
            $course = $this->courseService->update(
                $request,
                $course,
                $request->validated()
            );

            // sync categories
            if ($request->filled('categories')) {

                $this->courseService->syncCategories(
                    $course,
                    $request->categories
                );
            } else {

                $course->categories()->detach();
            }

            if ($request->filled('sections')) {

                $course->sections()->delete();

                foreach ($request->sections as $index => $section) {

                    $this->sectionService->create([
                        'course_id' => $course->id,
                        'title' => $section['title'],
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return to_route('instructor.index')->with('success', 'Course updated successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Course update failed', [
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Failed to update course.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return to_route('instructor.index')->with('success', 'Course Delete successfully.');
    }
}
