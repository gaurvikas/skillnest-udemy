<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\StripeConnectService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessInstructorTransfers implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public function handle(StripeConnectService $stripeService): void
    {
        Log::info('ProcessInstructorTransfers: Starting...');

        $orders = Order::with(['items.course'])
            ->where('status', Order::STATUS_PAID)
            ->where('transfer_status', 'pending')
            ->whereNotNull('payment_intent_id')
            ->get();

        Log::info("ProcessInstructorTransfers: {$orders->count()} orders found.");

        foreach ($orders as $order) {
            try {
                // Har instructor ke liye amount calculate karo
                $instructorAmounts = [];
                foreach ($order->items as $item) {
                    $instructorId = $item->course->instructor_id;
                    $instructorAmounts[$instructorId] =
                        ($instructorAmounts[$instructorId] ?? 0) + $item->price;
                }

                $allTransferred = true;

                foreach ($instructorAmounts as $instructorId => $amount) {
                    $amountCents = (int) round($amount * 100);

                    $transferId = $stripeService->transferToInstructor(
                        paymentIntentId: $order->payment_intent_id,
                        instructorId: $instructorId,
                        amountCent: $amountCents,
                        orderId: $order->id
                    );

                    if (! $transferId) {
                        $allTransferred = false;
                        Log::warning("Order #{$order->order_number}: Instructor {$instructorId} not connected stripe account.");
                    } else {
                        Log::info("Order #{$order->order_number}: Instructor {$instructorId} transfer successful.");
                    }
                }

                $order->update([
                    'transfer_status' => $allTransferred ? 'transferred' : 'skipped',
                ]);
            } catch (\Exception $e) {
                Log::error("Order #{$order->order_number} transfer failed: ".$e->getMessage());

                continue;
            }
        }

        Log::info('ProcessInstructorTransfers: Done.');
    }
}
