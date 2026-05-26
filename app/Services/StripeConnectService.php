<?php

// app/Services/StripeConnectService.php

namespace App\Services;

use App\Models\InstructorStripeAccount;
use App\Models\User;
use Stripe\StripeClient;

class StripeConnectService
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    // ── 1. Account banana ya existing return karna ──
    public function createOrGetExpressAccount(User $instructor): string
    {
        $existing = InstructorStripeAccount::where('user_id', $instructor->id)->first();
        if ($existing) {
            return $existing->stripe_account_id;
        }

        $account = $this->stripe->accounts->create([
            'type' => 'express',
            'country' => 'US',
            'email' => $instructor->email,
            'capabilities' => ['transfers' => ['requested' => true]],
            'metadata' => ['user_id' => $instructor->id],
        ]);

        InstructorStripeAccount::create([
            'user_id' => $instructor->id,
            'stripe_account_id' => $account->id,
            'status' => 'pending',
            'payouts_enabled' => false,
            'charges_enabled' => false,
        ]);

        return $account->id;
    }

    // ── 2. Onboarding link ──
    public function createOnboardingLink(User $instructor): string
    {
        $accountId = $this->createOrGetExpressAccount($instructor);

        $link = $this->stripe->accountLinks->create([
            'account' => $accountId,
            'refresh_url' => route('instructor.stripe.onboard'),
            'return_url' => route('instructor.stripe.success'),
            'type' => 'account_onboarding',
        ]);

        return $link->url;
    }

    // ── 3. Stripe se status sync ──
    public function syncAccountStatus(User $instructor): string
    {
        $record = InstructorStripeAccount::where('user_id', $instructor->id)->first();
        if (! $record) {
            return 'not_connected';
        }

        $account = $this->stripe->accounts->retrieve($record->stripe_account_id);

        $record->update([
            'charges_enabled' => $account->charges_enabled,
            'payouts_enabled' => $account->payouts_enabled,
            'status' => $account->payouts_enabled ? 'active' : 'pending',
        ]);

        return $record->status;
    }

    // ── 4. Express Dashboard link ──
    public function getDashboardLink(User $instructor): string
    {
        $record = InstructorStripeAccount::where('user_id', $instructor->id)
            ->firstOrFail();

        $link = $this->stripe->accounts->createLoginLink(
            $record->stripe_account_id
        );

        return $link->url;
    }

    public function transferToInstructor(
        string $paymentIntentId,
        int $instructorId,
        int $amountCent,
        int $orderId
    ): ?string {
        $stripeAccount = InstructorStripeAccount::where('user_id', $instructorId)
            ->where('payouts_enabled', true)
            ->first();

        if (! $stripeAccount) {
            return null;
        }

        $platformFeePercent = 20;
        $platformFee = (int) round($amountCent * $platformFeePercent / 100);
        $transferAmount = $amountCent - $platformFee;

        $transfer = $this->stripe->transfers->create([
            'amount' => $transferAmount,
            'currency' => 'usd',
            'destination' => $stripeAccount->stripe_account_id,
            'metadata' => [
                'order_id' => $orderId,
                'instructor_id' => $instructorId,
            ],
        ]);

        return $transfer->id;
    }
}
