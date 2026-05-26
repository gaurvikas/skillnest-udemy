@extends('frontend.layouts.app')
@section('title', 'Checkout - SkillNest')
@section('content')

    <div class="bg-gray-50 min-h-screen py-6 sm:py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <h1 class="font-sora text-xl sm:text-2xl font-bold">Checkout</h1>
                <p class="text-sm sm:text-base text-gray-600">Complete your purchase securely</p>
            </div>

            <form action="{{ isset($course) ? route('buy.store', $course->id) : route('checkout.store') }}" method="POST">
                @csrf

                <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

                    {{-- LEFT COLUMN - Billing Information --}}
                    <div class="flex-1 w-full space-y-5 sm:space-y-6">

                        {{-- Billing Information Card --}}
                        <div class="bg-white rounded  shadow-sm border border-gray-200 overflow-hidden">

                            {{-- Card Header --}}
                            <div class="px-5 sm:px-6 md:px-8 py-5 sm:py-6 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded flex items-center justify-center">
                                        <i class="fas fa-file-invoice text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h2 class="font-sora text-lg sm:text-xl font-bold text-gray-900">Billing Information
                                        </h2>
                                        <p class="text-xs text-gray-500">Enter your billing details</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 sm:p-6 md:p-8">
                                <div class="space-y-5">

                                    {{-- Country & State Row --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        {{-- Country --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-globe text-purple-500 mr-1"></i> Country *
                                            </label>
                                            <select id="country-select" name="country" required
                                                class="w-full border-2 border-gray-200 rounded px-3 sm:px-4 py-2.5 sm:py-3 text-sm outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100 cursor-pointer transition">
                                                <option value="">Loading countries...</option>
                                            </select>
                                        </div>

                                        {{-- State --}}
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-map-marker-alt text-purple-500 mr-1"></i> State / Province
                                                *
                                            </label>
                                            <select id="state-select" name="state" required
                                                class="w-full border-2 border-gray-200 rounded px-3 sm:px-4 py-2.5 sm:py-3 text-sm outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100 cursor-pointer transition">
                                                <option value="">Select country first</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Secure Notice --}}
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                                            <div>
                                                <p class="text-sm font-semibold text-blue-900 mb-1">Secure Checkout</p>
                                                <p class="text-xs text-blue-700">Your payment information is protected with
                                                    industry-standard encryption.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Trust Badges (Desktop) --}}
                        <div class="hidden lg:block bg-white rounded shadow-sm border border-gray-200 p-5">
                            <div class="flex flex-wrap items-center justify-center gap-6">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-lock text-green-600"></i>
                                    <span>Secure Payment</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-shield-alt text-blue-600"></i>
                                    <span>SSL Encrypted</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-undo text-amber-600"></i>
                                    <span>30-Day Refund</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN - Order Summary --}}
                    <div class="w-full lg:w-96 shrink-0">
                        <div class="lg:sticky lg:top-20 bg-white rounded  shadow-lg border border-gray-200 overflow-hidden">

                            {{-- Header --}}
                            <div
                                class="px-5 sm:px-6 py-5 sm:py-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                                <h2 class="font-sora text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-shopping-bag text-purple-600"></i>
                                    Order Summary
                                </h2>
                                <p class="text-xs text-gray-600 mt-1">
                                    @isset($course)
                                        1 course
                                    @else
                                        {{ count($cart->items) }} {{ count($cart->items) === 1 ? 'course' : 'courses' }}
                                    @endisset
                                    in cart
                                </p>
                            </div>

                            {{-- Items --}}
                            <div
                                class="p-5 sm:p-6 border-b border-gray-200 max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                <div class="space-y-4">

                                    @isset($course)
                                        {{-- Buy Now — single course --}}
                                        <div class="flex gap-3">
                                            <div class="shrink-0">
                                                <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: 'https://placehold.co/80x80/667eea/white?text=Course' }}"
                                                    alt="Course" class="w-16 h-16 sm:w-20 sm:h-20 rounded object-cover">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">
                                                    {{ $course->title }}
                                                </h3>
                                                <p class="text-xs text-gray-500">By {{ $course->instructor->name }}</p>
                                                <p class="text-sm font-bold text-purple-600 mt-1">
                                                    ${{ number_format($course->price ?? $course->original_price) }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Cart — multiple courses --}}
                                        @foreach ($cart->items as $item)
                                            <div class="flex gap-3 group">
                                                <div class="relative shrink-0">
                                                    <img src="{{ $item->course->getFirstMediaUrl('thumbnail') ?: 'https://placehold.co/80x80/667eea/white?text=Course' }}"
                                                        alt="Course" class="w-16 h-16 sm:w-20 sm:h-20 rounded object-cover">
                                                    <div
                                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded transition">
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3
                                                        class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1 group-hover:text-purple-600 transition">
                                                        {{ $item->course->title }}
                                                    </h3>
                                                    <p class="text-xs text-gray-500">By {{ $item->course->instructor->name }}
                                                    </p>
                                                    <p class="text-sm font-bold text-purple-600 mt-1">
                                                        ${{ number_format($item->price) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset

                                </div>
                            </div>

                            {{-- Coupon Code — Dono ke liye --}}
                            <div class="p-5 sm:p-6 border-b border-gray-200 bg-gray-50">
                                <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wider">
                                    <i class="fas fa-tag text-purple-500 mr-1"></i> Have a coupon?
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" id="couponInput" name="coupon_code" placeholder="Enter code"
                                        class="flex-1 border-2 border-gray-200 rounded px-3 sm:px-4 py-2.5 text-sm outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100 transition">
                                    <button type="button" onclick="applyCoupon()" id="applyCouponBtn"
                                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 sm:px-6 py-2.5 rounded text-sm transition text-center">
                                        Apply
                                    </button>
                                </div>
                                <p id="couponMsg" class="text-xs mt-1.5"></p>
                            </div>

                            {{-- Price Breakdown --}}
                            <div class="p-5 sm:p-6 space-y-3"
                                @isset($course)
                                    id="cartData" data-original="{{ $course->price ?? $course->original_price }}"
                                @else
                                    id="cartData" data-original="{{ $totalOriginalPrice }}"
                                @endisset>

                                @isset($course)
                                    {{-- Buy Now pricing --}}
                                    @php $coursePrice = $course->price ?? $course->original_price; @endphp

                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-medium">${{ number_format($coursePrice) }}</span>
                                    </div>

                                    {{-- Coupon row — hidden by default --}}
                                    <div id="couponRow" class="flex justify-between text-sm hidden">
                                        <span class="text-gray-600 flex items-center gap-1">
                                            Coupon
                                            <button type="button" id="removeCouponBtn"
                                                class="text-gray-400 hover:text-red-500 text-xs font-bold transition ml-1"
                                                title="Remove coupon">✕</button>
                                        </span>
                                        <span class="text-green-600 font-medium">
                                            -$<span id="summaryCoupon">0</span>
                                        </span>
                                    </div>

                                    <div class="border-t-2 border-gray-200 pt-3 mt-3">
                                        <div class="flex justify-between items-baseline mb-4">
                                            <span class="text-base font-semibold text-gray-900">Total:</span>
                                            <div class="text-right">
                                                <span id="summaryTotal" class="text-2xl font-bold text-purple-600">
                                                    ${{ number_format($coursePrice) }}
                                                </span>
                                                <p id="youSaveBadge" class="text-xs text-green-600 font-semibold mt-1"></p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Cart pricing --}}
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="text-gray-900 font-medium">
                                            ${{ number_format($cart->subtotal) }}
                                        </span>
                                    </div>

                                    <div id="couponRow"
                                        class="flex justify-between text-sm {{ $cart->discount_total > 0 ? '' : 'hidden' }}">
                                        <span class="text-gray-600 flex items-center gap-1">
                                            Coupon
                                            <button type="button" id="removeCouponBtn"
                                                class="text-gray-400 hover:text-red-500 text-xs font-bold transition"
                                                title="Remove coupon">✕</button>
                                        </span>
                                        <span class="text-green-600 font-medium">
                                            -$<span id="summaryCoupon">{{ number_format($cart->discount_total) }}</span>
                                        </span>
                                    </div>

                                    <div class="border-t-2 border-gray-200 pt-3 mt-3">
                                        <div class="flex justify-between items-baseline mb-4">
                                            <span class="text-base font-semibold text-gray-900">Total:</span>
                                            <div class="text-right">
                                                <span id="summaryTotal" class="text-2xl font-bold text-purple-600">
                                                    ${{ number_format($cart->total) }}
                                                </span>
                                                <p id="youSaveBadge" class="text-xs text-green-600 font-semibold mt-1">
                                                    @if ($totalOriginalPrice - $cart->total > 0)
                                                        🎉 You save ${{ number_format($totalOriginalPrice - $cart->total) }}!
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endisset

                                {{-- Submit Button --}}
                                <button type="submit" id="submitBtn"
                                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 rounded text-base transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    <i class="fas fa-lock"></i>
                                    @isset($course)
                                        Buy Now
                                    @else
                                        Complete Purchase
                                    @endisset
                                </button>

                                <p class="text-xs text-center text-gray-500 mt-3">
                                    By completing your purchase you agree to our
                                    <a href="#" class="text-purple-600 hover:underline">Terms of Service</a>
                                </p>

                            </div>

                            {{-- 30-Day Guarantee --}}
                            <div class="px-5 sm:px-6 py-4 bg-green-50 border-t border-green-200">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                        <i class="fas fa-shield-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-green-900">30-Day Money-Back Guarantee</p>
                                        <p class="text-xs text-green-700">Full refund if you're not satisfied</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

            {{-- Trust Badges (Mobile) --}}
            <div class="lg:hidden mt-8 py-6 border-t border-gray-200">
                <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                        <i class="fas fa-lock text-green-600"></i>
                        <span>Secure</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                        <i class="fas fa-shield-alt text-blue-600"></i>
                        <span>Encrypted</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                        <i class="fas fa-credit-card text-purple-600"></i>
                        <span>PCI Compliant</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                        <i class="fas fa-undo text-amber-600"></i>
                        <span>30-Day Refund</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Country/State Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const countrySelect = document.getElementById('country-select');
            const stateSelect = document.getElementById('state-select');
            const headers = {
                'X-CSCAPI-KEY': 'OFM3ZjdMMnZJUVowbGt6SWRiYjF5bjhYNENZQUVvSmM0Y09Ndnc2RA=='
            };

            const getCountries = async () => {
                try {
                    const res = await fetch('https://api.countrystatecity.in/v1/countries', {
                        headers
                    });
                    return await res.json();
                } catch (e) {
                    return [];
                }
            };

            const getStatesByCountry = async (code) => {
                try {
                    const res = await fetch(
                        `https://api.countrystatecity.in/v1/countries/${code}/states`, {
                            headers
                        });
                    return await res.json();
                } catch (e) {
                    return [];
                }
            };

            const countries = await getCountries();
            countrySelect.innerHTML = '<option value="">Select Country</option>';
            countries.forEach(c => {
                const o = document.createElement('option');
                o.textContent = c.name;
                o.value = c.iso2;
                countrySelect.appendChild(o);
            });

            countrySelect.addEventListener('change', async function() {
                const code = this.value;
                stateSelect.innerHTML = '<option value="">Loading states...</option>';
                stateSelect.disabled = true;
                if (!code) {
                    stateSelect.innerHTML = '<option value="">Select country first</option>';
                    return;
                }
                const states = await getStatesByCountry(code);
                stateSelect.innerHTML = '<option value="">Select State</option>';
                stateSelect.disabled = false;
                states.forEach(s => {
                    const o = document.createElement('option');
                    o.textContent = s.name;
                    o.value = s.iso2;
                    stateSelect.appendChild(o);
                });
            });
        });
    </script>

    @push('scripts')
        <script>
            const CSRF = document.querySelector('meta[name="csrf-token"]').content;
            const IS_BUY_NOW = {{ isset($course) ? 'true' : 'false' }};
            const ORIGINAL_PRICE =
                {{ isset($course) ? $course->price ?? $course->original_price : $totalOriginalPrice ?? 0 }};

            // ================= APPLY COUPON =================
            async function applyCoupon() {
                const input = document.getElementById('couponInput');
                const msgBox = document.getElementById('couponMsg');
                const code = input.value.trim();

                if (!code) {
                    msgBox.textContent = "Please enter a coupon code.";
                    msgBox.className = "text-xs mt-1.5 text-red-500";
                    return;
                }

                try {
                    const COUPON_URL = IS_BUY_NOW ?
                        "{{ isset($course) ? route('buy.coupon.apply', $course->id) : '' }}" :
                        "{{ route('cart.coupon.apply') }}";

                    const res = await fetch(COUPON_URL, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": CSRF,
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            coupon_code: code
                        }) // price nahi chahiye ab
                    });

                    const data = await res.json();

                    if (!data.success) {
                        msgBox.textContent = data.message;
                        msgBox.className = "text-xs mt-1.5 text-red-500";
                        return;
                    }

                    // Success
                    msgBox.textContent = "✅ " + data.message;
                    msgBox.className = "text-xs mt-1.5 text-green-600";

                    const finalTotal = Number(data.final_total);

                    document.getElementById("summaryTotal").textContent =
                        "$" + finalTotal.toLocaleString("en-IN");

                    document.getElementById("summaryCoupon").textContent =
                        Number(data.coupon_discount).toLocaleString("en-IN");

                    document.getElementById("couponRow").classList.remove("hidden");

                    document.getElementById("youSaveBadge").textContent =
                        "🎉 You save $" + (ORIGINAL_PRICE - finalTotal).toLocaleString("en-IN") + "!";

                    // Button update
                    const submitBtn = document.getElementById("submitBtn");
                    if (IS_BUY_NOW && submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-lock"></i> Buy Now — $' + finalTotal.toLocaleString(
                            "en-IN");
                    }

                    input.readOnly = true;
                    input.classList.add('opacity-50');

                } catch (e) {
                    document.getElementById('couponMsg').textContent = "Something went wrong.";
                    document.getElementById('couponMsg').className = "text-xs mt-1.5 text-red-500";
                }
            }

            // ================= REMOVE COUPON =================
            document.addEventListener("click", async function(e) {
                if (e.target.id !== "removeCouponBtn") return;

                if (IS_BUY_NOW) {
                    // Buy Now — sirf UI reset, no API
                    document.getElementById("summaryTotal").textContent =
                        "$" + ORIGINAL_PRICE.toLocaleString("en-IN");
                    document.getElementById("couponRow").classList.add("hidden");
                    document.getElementById("youSaveBadge").textContent = "";

                    const submitBtn = document.getElementById("submitBtn");
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-lock"></i> Buy Now — $' + ORIGINAL_PRICE
                            .toLocaleString("en-IN");
                    }

                    const input = document.getElementById("couponInput");
                    input.readOnly = false;
                    input.classList.remove('opacity-50');
                    input.value = "";
                    document.getElementById("applyCouponBtn").disabled = true;
                    document.getElementById("couponMsg").textContent = "Coupon removed.";
                    document.getElementById("couponMsg").className = "text-xs mt-1.5 text-green-600";
                    return;
                }

                // Cart — API call
                try {
                    const res = await fetch("{{ route('cart.coupon.remove') }}", {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": CSRF,
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        }
                    });

                    const data = await res.json();
                    if (!data.success) {
                        alert(data.message);
                        return;
                    }

                    const finalTotal = Number(data.final_total);
                    document.getElementById("summaryTotal").textContent =
                        "$" + finalTotal.toLocaleString("en-IN");
                    document.getElementById("couponRow").classList.add("hidden");

                    const originalPrice = Number(document.getElementById('cartData')?.dataset.original ?? 0);
                    document.getElementById("youSaveBadge").textContent =
                        "🎉 You save $" + (originalPrice - finalTotal).toLocaleString("en-IN") + "!";

                    const input = document.getElementById("couponInput");
                    input.readOnly = false;
                    input.classList.remove('opacity-50', 'cursor-not-allowed');
                    input.value = "";
                    document.getElementById("applyCouponBtn").disabled = false;
                    document.getElementById("couponMsg").textContent = "Coupon removed.";
                    document.getElementById("couponMsg").className = "text-xs mt-1.5 text-green-600";

                } catch (e) {
                    alert("Something went wrong.");
                }
            });
        </script>
    @endpush

@endsection
