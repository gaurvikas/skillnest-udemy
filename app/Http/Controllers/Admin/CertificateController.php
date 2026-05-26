<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Services\CertificateService;

class CertificateController extends Controller
{
    public function __construct(protected readonly CertificateService $certificateService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = Certificate::latest()->paginate(20);

        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.certificates.create', compact('users', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificateRequest $request)
    {

        $data = $request->validated();

        $this->certificateService->create($request, $data);

        return to_route('admin.certificates.index')->with('status', 'Certificate Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.certificates.show', compact('users', 'course', 'certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        $users = User::pluck('name', 'id');

        $course = Course::pluck('title', 'id');

        return view('admin.certificates.edit', compact('users', 'course', 'certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificateRequest $request, Certificate $certificate)
    {
        $data = $request->validated();

        $this->certificateService->update($request, $certificate, $data);

        return to_route('admin.certificates.index')->with('status', 'Course Created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return to_route('admin.certificates.index')->with('status', 'Certificate Deleted successfully!');
    }
}
