<?php

namespace App\Http\Controllers;

use App\Services\StripeConnectService;

class InstructorStripeController extends Controller
{
    public function __construct(protected StripeConnectService $service) {}

    public function onboard()
    {
        $url = $this->service->createOnboardingLink(auth()->user());

        return redirect($url);
    }

    public function success()
    {
        $this->service->syncAccountStatus(auth()->user());

        return redirect()->route('instructor.dashboard')
            ->with('success', '✅ Stripe account connected!');
    }

    public function dashboard()
    {
        $url = $this->service->getDashboardLink(auth()->user());

        return redirect($url);
    }
}
