<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $bestSellingCourses = Course::with(['user', 'media'])->withAvg('reviews', 'rating')->withCount('reviews')->oldest()->limit(4)->get();

        $wishlistItems = Wishlist::with(['course.instructor'])->where('user_id', auth()->id())->get();

        return view('frontend.pages.wishlist', compact('wishlistItems', 'bestSellingCourses'));
    }

    public function store(Course $courseId)
    {
        $user = auth()->user();

        $exist = $user->wishlist()->where('course_id', $courseId->id)->exists();

        if ($exist) {
            return back()->with('error', 'Already in wishlist');
        }

        $user->wishlist()->create([
            'course_id' => $courseId->id,
        ]);

        return back()->with('success', 'Added to wishlist');
    }

    public function remove($courseId)
    {
        $item = Wishlist::where('course_id', $courseId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Removed from wishlist');
    }
}
