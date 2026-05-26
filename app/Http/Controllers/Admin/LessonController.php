<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\LessonService;

class LessonController extends Controller
{
    public function __construct(protected readonly LessonService $LessonService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::latest()->paginate(20);

        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::pluck('title', 'id');

        return view('admin.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        // $data = $request->all();
        $data = $request->validated();

        // dd($request->all());
        $this->LessonService->create($request, $data);

        return to_route('admin.lessons.index')->with('status', 'lesson Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {

        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $courses = Course::pluck('title', 'id');

        $existingLessons = Lesson::whereHas('section', function ($query) use ($lesson) {
            $query->where('course_id', $lesson->section->course_id);
        })->with('media')->get()->groupBy('section_id');

        return view('admin.lessons.edit', compact('courses', 'lesson', 'existingLessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $this->LessonService->update($request, $lesson);

        return to_route('admin.lessons.index')
            ->with('status', 'Lessons updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return to_route('admin.lessons.index')->with('status', 'Lesson Deleted successfully!');
    }
}
