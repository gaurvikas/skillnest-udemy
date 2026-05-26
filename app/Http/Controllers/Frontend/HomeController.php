<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\User;
use App\Services\ContactService;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(protected readonly CourseService $courseService, protected readonly ContactService $contactService) {}

    public function index()
    {
        $topCategories = Cache::remember('home_top_categories', 3600, function () {
            return Category::whereNull('parent_id')->where('status', 1)->withCount('courses')->limit(18)->get();
        });

        $bestSellingCourses = Cache::remember('home_best_selling_courses', 3600, function () {
            return Course::with(['user', 'media'])->withAvg('reviews', 'rating')->withCount(['reviews', 'enrollments'])->orderByDesc('enrollments_count')->published()->latest()->limit(8)->get();
        });

        $totalCourses = Course::count();
        $reviews = CourseReview::with('user')->latest()->take(3)->get();

        $topInstructors = Cache::remember('home_top_instructors', 3600, function () {

            return User::whereHas('roles', function ($q) {
                $q->where('name', 'instructor');
            })
                ->withCount([
                    'courses',
                    'courses as lessons_count' => function ($q) {
                        $q->join('sections', 'courses.id', '=', 'sections.course_id')
                            ->join('lessons', 'sections.id', '=', 'lessons.section_id');
                    },
                    'courses as reviews_count' => function ($q) {
                        $q->join('course_reviews', 'courses.id', '=', 'course_reviews.course_id');
                    },
                ])
                ->orderByDesc('reviews_count')
                ->orderByDesc('courses_count')
                ->take(4)
                ->get();
        });

        return view('frontend.pages.home', compact('bestSellingCourses', 'topCategories', 'totalCourses', 'reviews'));
    }

    public function course($slug)
    {
        $course = Course::where('slug', $slug)->with(['sections.lessons'])->firstOrFail();
        $isPurchased = auth()->check() ? auth()->user()->enrollments()->where('course_id', $course->id)->exists() : false;
        $inCart = false;
        if (auth()->check()) {
            $cart = auth()->user()->cart()->with('items')->first();
            $inCart = $cart?->items->contains('course_id', $course->id) ?? false;
        }

        return view('frontend.pages.course.detail', compact('course', 'isPurchased', 'inCart'));
    }

    public function list(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'subcategory' => 'nullable|string|max:255',
        ]);

        // if (! $request->filled('query') && ! $request->filled('category')) {
        //     return redirect()->route('index');
        // }

        $courses = $this->courseService->search($request);

        return view('frontend.pages.course.list', compact('courses'));
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $this->contactService->create($data, $request->ip());

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
        ]);
    }
}
