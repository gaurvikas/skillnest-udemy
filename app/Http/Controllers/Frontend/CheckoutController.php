<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected readonly OrderService $orderService) {}

    public function index()
    {
        $cart = auth()->user()->cart;

        if (! $cart || $cart->items()->count() === 0) {
            return to_route('cart')->with('error', 'Your cart is empty.');
        }

        $totalOriginalPrice = $cart->items->sum(function ($item) {
            return $item->course->original_price ?? $item->price;
        });

        return view('frontend.pages.checkout', compact('cart', 'totalOriginalPrice'));
    }

    public function store(Request $request)
    {
        return $this->orderService->create($request);
    }
}
