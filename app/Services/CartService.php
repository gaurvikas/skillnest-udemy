<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;

class CartService
{
    // ==========Cart==========
    public function addToCart(int $courseId): array
    {
        $user = auth()->user();

        if (! $user) {
            return ['message' => false, 'error' => 'Please login first.'];
        }

        $course = Course::find($courseId);

        if (! $course) {
            return ['success' => false, 'message' => 'Course not found.'];
        }

        $isPurchased = auth()->user()->enrollments()->where('course_id', $course->id)->exists();

        if ($isPurchased) {
            return ['success' => false, 'message' => 'Course already purchased.'];
        }

        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        // Prevent duplicate in cart
        if ($cart->items()->where('course_id', $courseId)->exists()) {
            return ['message' => true, 'success' => 'Course already in cart.'];
        }

        // Add item
        $cart->items()->create([
            'course_id' => $courseId,
            'price' => $course->price ?? 0,
        ]);

        // Recalculate totals
        $this->recalculateCart($cart);

        return ['message' => true, 'success' => 'Course added to cart successfully.'];
    }

    // ==========Remove cart==========
    public function removeFromCart(int $courseId): array
    {
        $user = auth()->user();
        if (! $user) {
            return ['success' => 'Please login first.'];
        }

        $cart = $user->cart;
        if (! $cart) {
            return ['success' => true, 'message' => 'Cart not found.'];
        }

        $item = $cart->items()->where('course_id', $courseId)->first();
        if (! $item) {
            return ['success' => true, 'message' => 'Item not found in cart.'];
        }

        $item->delete();

        $this->recalculateCart($cart);

        return ['success' => true, 'message' => 'Course removed from cart.'];
    }

    // ==========Apply Coupon==========
    public function applyCoupon(string $code): array
    {
        $user = auth()->user();
        if (! $user) {
            return ['success' => true, 'message' => 'Please login first.'];
        }

        $cart = $user->cart;
        if (! $cart || $cart->items()->count() === 0) {
            return ['success' => true, 'message' => 'Cart is empty.'];
        }

        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $this->isCouponValid($coupon)) {
            return ['success' => true, 'message' => 'Invalid or expired coupon.'];
        }

        $cart->update([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
        ]);

        $this->recalculateCart($cart);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'subtotal' => $cart->subtotal,
            'coupon_discount' => $cart->discount_total,
            'final_total' => $cart->total,
        ];
    }

    // ==========Recalculate Cart==========

    private function recalculateCart(Cart $cart): void
    {
        $subtotal = $cart->items()->sum('price');
        $discount = 0;

        if ($subtotal <= 0) {
            $cart->update([
                'subtotal' => 0,
                'discount_total' => 0,
                'total' => 0,
                'coupon_id' => null,
                'coupon_code' => null,
            ]);

            return;
        }

        if ($cart->coupon_id) {
            $coupon = Coupon::find($cart->coupon_id);

            if ($coupon && $this->isCouponValid($coupon)) {

                if ($coupon->type === 'fixed') {
                    $discount = $coupon->value;
                }

                if ($coupon->type === 'percentage') {
                    $discount = ($subtotal * $coupon->value) / 100;

                    if ($coupon->max_discount) {
                        $discount = min($discount, $coupon->max_discount);
                    }
                }

                $discount = min($discount, $subtotal);
            } else {
                $cart->update([
                    'coupon_id' => null,
                    'coupon_code' => null,
                ]);
            }
        }

        $discount = round($discount, 2);
        $total = max(0, $subtotal - $discount);

        $cart->update([
            'subtotal' => $subtotal,
            'discount_total' => $discount,
            'total' => $total,
        ]);
    }

    // ========== Coupon Validation ==========

    private function isCouponValid(Coupon $coupon): bool
    {
        return $coupon->is_active &&
            (! $coupon->expires_at || now()->lte($coupon->expires_at)) &&
            (! $coupon->usage_limit || $coupon->used_count < $coupon->usage_limit);
    }
}
