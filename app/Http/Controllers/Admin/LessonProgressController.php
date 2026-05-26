<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonProgressRequest;
use App\Http\Requests\UpdateLessonProgressRequest;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Services\LessonProgressService;

class LessonProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected readonly LessonProgressService $lessonProgress) {}

    public function index()
    {

        $LessonProgress = LessonProgress::latest()->paginate(20);

        return view('admin.lesson-progress.index', compact('LessonProgress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        $lessons = Lesson::pluck('title', 'id');

        return view('admin.lesson-progress.create', compact('users', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonProgressRequest $request)
    {
        $data = $request->validated();

        $this->lessonProgress->create($data);

        return to_route('admin.lesson-progress.index')->with('status', 'LessonProgress Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LessonProgress $LessonProgress)
    {
        return view('admin.lesson-progress.show', compact('LessonProgress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LessonProgress $LessonProgress)
    {
        $users = User::pluck('name', 'id');

        $lessons = Lesson::pluck('title', 'id');

        return view('admin.lesson-progress.edit', compact('users', 'lessons', 'LessonProgress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonProgressRequest $request, LessonProgress $lessonProgress)
    {
        $data = $request->validated();

        $this->lessonProgress->update($lessonProgress, $data);

        return to_route('admin.lesson-progress.index')->with('status', 'LessonProgress Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LessonProgress $LessonProgress)
    {
        $LessonProgress->delete();

        return to_route('admin.lesson-progress.index')->with('status', 'LessonProgress Deleted successfully!');
    }
}
