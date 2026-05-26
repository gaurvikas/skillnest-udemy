<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyNowService
{
    public function create(Course $course, Request $request)
    {
        $user = auth()->user();

        return DB::transaction(function () use ($user, $course, $request) {

            $price = $course->price ?? $course->original_price;
            $discount = 0;
            $couponCode = null;

            // ─── Coupon check ───
            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    })
                    ->first();

                if ($coupon) {
                    if ($coupon->type === 'fixed') {
                        $discount = $coupon->value;
                    } elseif ($coupon->type === 'percentage') {
                        $discount = ($price * $coupon->value) / 100;
                        if ($coupon->max_discount) {
                            $discount = min($discount, $coupon->max_discount);
                        }
                    }

                    $discount = round(min($discount, $price), 2);
                    $couponCode = $coupon->code;

                    // Coupon usage count increment karo
                    $coupon->increment('used_count');
                }
            }

            $total = max(0, $price - $discount);

            // Order create
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $price,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'total' => $total,
                'country' => $request->country,
                'state' => $request->state,
                'status' => Order::STATUS_PENDING,
            ]);

            // Order Item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $price,
            ]);

            // Stripe Checkout
            $checkout = $user->checkout([
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) round($total * 100),
                        'product_data' => [
                            'name' => $course->title,
                        ],
                    ],
                    'quantity' => 1,
                ],
            ], [
                'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('courses.show', $course->slug),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
            ]);

            $order->update(['stripe_session_id' => $checkout->id]);

            return $checkout;
        });
    }
}
