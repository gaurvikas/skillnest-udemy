<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CoursesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Imports\CoursesImport;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use App\Services\CourseService;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected readonly CourseService $courseService, protected readonly SectionService $sectionService) {}

    public function index()
    {
        $courses = Course::latest()->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view('admin.courses.create', compact('users', 'categories'));
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

            if ($request->filled('categories')) {
                $this->courseService->syncCategories(
                    $course,
                    $request->categories
                );
            }

            if ($request->filled('sections')) {

                foreach ($request->sections as $index => $section) {

                    $this->sectionService->create([
                        'course_id' => $course->id,
                        'title' => $section['title'],
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return to_route('admin.courses.index')
                ->with('success', 'Course created successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Course creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create course.');
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
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view('admin.courses.edit', compact('course', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $course = $this->courseService->update(
                $request,
                $course,
                $request->validated()
            );

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

            return to_route('admin.courses.index')
                ->with('success', 'Course updated successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Course update failed', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update course.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return back();
    }

    public function export()
    {
        return Excel::download(new CoursesExport, 'courses.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new CoursesImport, $request->file('file'));

        return back()->with('success', 'Courses Imported Successfully');
    }
}
