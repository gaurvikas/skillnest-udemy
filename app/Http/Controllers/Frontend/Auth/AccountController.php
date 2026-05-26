<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(protected readonly UserService $userService) {}

    public function index()
    {
        $user = auth()->user();

        $myCertificates = Certificate::with('course.instructor')->where('user_id', $user->id)->get();
        $enrolledCourses = Enrollment::where('user_id', $user->id)->with('course.instructor', 'course.media', 'course.sections.lessons')->latest()->get();

        return view('frontend.pages.account', compact('myCertificates', 'enrolledCourses', 'user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user(); // logged in user

        $data = $request->all();
        $user->update($data);

        return to_route('profile')->with('status', 'Profile updated successfully');
    }
}
