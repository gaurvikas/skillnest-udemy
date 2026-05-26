<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\EnrollmentService;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected readonly EnrollmentService $EnrollmentService) {}

    public function index()
    {
        $enrollments = Enrollment::latest()->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        $courses = Course::pluck('title', 'id');

        return view('admin.enrollments.create', compact('users', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $data = $request->validated();

        $this->EnrollmentService->create($data);

        return to_route('admin.enrollments.index')->with('status', 'Enrollment Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $users = User::pluck('name', 'id');

        $courses = Course::pluck('title', 'id');

        return view('admin.enrollments.edit', compact('enrollment', 'users', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $data = $request->validated();

        $this->EnrollmentService->update($enrollment, $data);

        return to_route('admin.enrollments.index')->with('status', 'Enrollment updated  successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return to_route('admin.enrollments.index')->with('status', 'Enrollment deleted successfully!');
    }
}
