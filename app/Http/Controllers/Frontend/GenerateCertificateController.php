<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Carbon\Carbon;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateCertificateController extends Controller
{
    public function index($slug)
    {
        $user = auth()->user();

        $course = Course::with('instructor')->where('slug', $slug)->first();

        $certificate = Certificate::where('user_id', $user->id)->where('course_id', $course->id)->firstOrFail();

        $completedAt = $certificate->issued_at ? Carbon::parse($certificate->issued_at) : null;

        return view('frontend.pages.certificate', compact('user', 'course', 'completedAt', 'certificate'));
    }

    public function download($courseId)
    {
        $user = auth()->user();

        $course = Course::with('instructor')->findOrFail($courseId);

        $certificate = Certificate::where('user_id', $user->id)->where('course_id', $courseId)->firstOrFail();

        $completedAt = $certificate->issued_at ? Carbon::parse($certificate->issued_at) : null;

        return Pdf::view('frontend.pages.certificate-pdf', compact('user', 'course', 'completedAt', 'certificate'))->format('A4')->pageRanges(1)->landscape()->margins(0, 0, 0, 0)->download('certificate-'.$course->slug.'.pdf');
    }
}
