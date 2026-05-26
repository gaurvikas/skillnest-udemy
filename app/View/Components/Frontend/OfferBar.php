<?php

namespace App\View\Components\Frontend;

use App\Models\Coupon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OfferBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $latestCoupon;

    public function __construct()
    {
        $this->latestCoupon = Coupon::where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->latest()
            ->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('frontend.components.offer-bar');
    }
}
