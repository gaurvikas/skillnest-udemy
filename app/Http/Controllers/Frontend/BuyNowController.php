<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Services\BuyNowService;
use Illuminate\Http\Request;

class BuyNowController extends Controller
{
    public function __construct(protected BuyNowService $buyNowService) {}

    public function index(Course $course)
    {
        if (auth()->user()->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('course.learn', $course->slug)
                ->with('info', 'You already own this course!');
        }

        return view('frontend.pages.checkout', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $checkout = $this->buyNowService->create($course, $request);

        return redirect($checkout->url);
    }

    // ─── Buy Now Coupon — Cart bypass ───
    public function applyCoupon(Request $request, Course $course)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        // CartService ka isCouponValid logic same use karo
        if (! $coupon || ! $this->isCouponValid($coupon)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon.',
            ]);
        }

        $subtotal = (float) ($course->price ?? $course->original_price);

        // CartService ka recalculate logic same use karo
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } elseif ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;
            if ($coupon->max_discount) {
                $discount = min($discount, $coupon->max_discount);
            }
        }

        $discount = round(min($discount, $subtotal), 2);
        $finalTotal = max(0, $subtotal - $discount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied! You saved $'.number_format($discount, 2),
            'coupon_discount' => $discount,
            'final_total' => $finalTotal,
        ]);
    }

    // CartService jaisa hi validation
    private function isCouponValid(Coupon $coupon): bool
    {
        return $coupon->is_active &&
            (! $coupon->expires_at || now()->lte($coupon->expires_at)) &&
            (! $coupon->usage_limit || $coupon->used_count < $coupon->usage_limit);
    }
}
