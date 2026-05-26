<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Order;
use App\Notifications\CoursePurchasedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    protected function handleCheckoutSessionCompleted(array $payload)
    {
        Log::info('Stripe checkout.session.completed received');

        $session = $payload['data']['object'];

        $order = Order::where('stripe_session_id', $session['id'])
            ->with(['items', 'user'])
            ->first();

        if (! $order) {
            Log::error('Order not found for session: '.$session['id']);

            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->status === Order::STATUS_PAID) {
            Log::info('Order already paid: '.$order->id);

            return response()->json(['message' => 'Already processed']);
        }

        if ($session['payment_status'] === 'paid') {
            DB::transaction(function () use ($order, $session) {
                $order->update([
                    'status' => Order::STATUS_PAID,
                    'paid_at' => now(),
                    'payment_intent_id' => $session['payment_intent'] ?? null,
                ]);

                foreach ($order->items as $item) {
                    if ($item->course_id) {
                        $alreadyEnrolled = Enrollment::where('user_id', $order->user->id)
                            ->where('course_id', $item->course_id)
                            ->exists();

                        if (! $alreadyEnrolled) {
                            Enrollment::create([
                                'user_id' => $order->user->id,
                                'course_id' => $item->course_id,
                                'enrolled_at' => now(),
                                'progress_percentage' => 0,
                            ]);
                        }
                    }
                }

                if ($order->user->cart) {
                    $order->user->cart->delete();
                }
            });

            $order->user->notify(new CoursePurchasedNotification($order));

            Log::info('Order marked as PAID: '.$order->id);
        } else {
            $order->update(['status' => Order::STATUS_FAILED]);
            Log::warning('Payment failed for order: '.$order->id);
        }

        return response()->json(['status' => 'success']);
    }
}
