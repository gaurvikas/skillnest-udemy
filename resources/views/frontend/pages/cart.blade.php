@extends('frontend.layouts.app')
@section('title', 'Shopping Cart - SkillNest')
@section('content')

    {{-- Hidden data for JS calculations --}}
    <div id="cartData" data-original="{{ $totalOriginalPrice }}" data-discounted="{{ $totalPriceBeforeDiscount }}"
        data-savings="{{ $totalSavings }}" data-coupon-discount="{{ $couponDiscount }}" data-final="{{ $subTotal }}"
        style="display:none;">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8 md:py-10">

        <h1 class="font-sora text-xl sm:text-2xl font-bold">Shopping Cart</h1>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- CART ITEMS --}}
            <div class="flex-1 w-full">
                <p class="text-sm text-gray-400 mb-5 border-b border-gray-200 pb-4">
                    <span class="font-semibold text-gray-900">{{ $cartItems->count() }}
                        Course{{ $cartItems->count() !== 1 ? 's' : '' }}</span> in Cart
                </p>

                @forelse($cartItems as $item)
                    <div class="flex gap-3 sm:gap-5 py-5 sm:py-6 border-b border-gray-200 cart-item"
                        data-course-id="{{ $item->course_id }}" data-price="{{ $item->price }}">
                        <div
                            class="w-20 h-16 sm:w-28 sm:h-20 rounded bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center text-xs shrink-0">
                            <img src="{{ $item->course->getFirstMediaUrl('thumbnail') ?: '🤖' }}"
                                alt="{{ $item->course->title }}" class="w-full h-full object-cover rounded">
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('courses.show', $item->course->slug) }}" class="block">
                                <h3
                                    class="font-sora font-bold text-xs sm:text-sm text-gray-900 leading-snug mb-1 line-clamp-2">
                                    {{ $item->course->title }}
                                </h3>
                            </a>
                            <p class="text-xs text-gray-400 mb-1.5">By {{ $item->course->instructor->name }}</p>
                            <div class="flex items-center gap-1.5 mb-1.5">
                                <span class="font-bold text-xs text-amber-700">
                                    {{ number_format($item->course->reviews()->avg('rating') ?? 0, 1) }}</span>
                                <span class="text-amber-400 text-xs">★★★★★</span>
                                <span class="text-[10px] text-gray-400 hidden sm:block">
                                    ({{ $item->course->reviews()->count() ?? 0 }})
                                </span>
                            </div>
                            <div class="hidden sm:flex gap-3 text-xs text-gray-400 mb-1">
                                <span><i class="fa fa-clock mr-1"></i>{{ $item->course->duration }}h</span>
                                <span><i class="fa fa-signal mr-1"></i>{{ $item->course->level }}</span>
                            </div>
                            <div class="flex gap-3 text-xs font-semibold mt-2">
                                <button class="text-purple-600 hover:underline remove-btn">Remove</button>
                                <form action="{{ route('wishlist.store', $item->course_id) }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="text-purple-600 hover:underline hidden sm:block">Wishlist</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="font-sora font-extrabold text-base sm:text-lg text-gray-900">
                                @if ($item->course->price)
                                    ${{ number_format($item->course->price) }}
                                @endif
                            </div>
                            <div class="text-xs text-gray-400 line-through">
                                ${{ number_format($item->course->original_price) }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm py-6 text-center">Your cart is empty.</p>
                @endforelse

            </div>

            {{-- ORDER SUMMARY --}}
            <div class="w-full lg:w-80 shrink-0">
                <div class="sticky top-20">
                    <div class="border border-gray-200 rounded overflow-hidden shadow-lg">

                        <div class="bg-gray-50 px-5 sm:px-6 py-4 border-b border-gray-200">
                            <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900">Order Summary</h2>
                        </div>

                        <div class="px-5 sm:px-6 py-5 space-y-3">

                            {{-- Original Price --}}
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Original Price</span>
                                <span class="line-through text-gray-400">${{ number_format($totalOriginalPrice) }}</span>
                            </div>

                            {{-- Discounts --}}
                            <div class="flex justify-between text-sm text-green-600 font-semibold">
                                <span>Discounts</span>
                                <span>${{ number_format($totalSavings) }}</span>
                            </div>

                            {{-- Coupon Row (hidden jab tak apply na ho) --}}
                            <div id="couponRow"
                                class="{{ $coupon ? '' : 'hidden' }} flex justify-between items-center text-sm text-purple-600 font-semibold transition-all duration-300">
                                <span class="flex items-center gap-1.5">
                                    Coupon:
                                </span>
                                <div class="flex items-center gap-2">
                                    <span>$<span id="summaryCoupon">{{ number_format($couponDiscount) }}</span></span>
                                    <button id="removeCouponBtn"
                                        class="text-gray-400 hover:text-red-500 text-xs font-bold transition"
                                        title="Remove coupon">✕</button>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                                <span class="font-sora font-extrabold text-lg sm:text-xl text-gray-900">Total</span>
                                <div class="text-right">
                                    <span id="summaryTotal"
                                        class="font-sora font-extrabold text-xl sm:text-2xl text-gray-900">
                                        ${{ number_format($subTotal) }}
                                    </span>
                                    <div class="text-xs text-gray-400 line-through">
                                        ${{ number_format($totalOriginalPrice) }}
                                    </div>
                                </div>
                            </div>

                            {{-- You Save Badge --}}
                            <div class="text-center">
                                <span id="youSaveBadge"
                                    class="text-xs text-green-600 font-semibold bg-green-50 px-3 py-1 rounded-full">
                                    🎉 You save ${{ number_format($totalOriginalPrice - $subTotal) }}!
                                </span>
                            </div>

                        </div>

                        <div class="px-5 sm:px-6 pb-4">
                            <a href="{{ url('/checkout') }}"
                                class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded text-center text-sm transition">
                                Proceed to Checkout →
                            </a>
                        </div>

                        {{-- Apply Coupon --}}
                        <div class="px-5 sm:px-6 pb-5">
                            <p class="text-xs font-semibold text-gray-900 mb-2">Apply Coupon</p>
                            <div class="flex gap-2">
                                <input type="text" id="couponInput" placeholder="Enter coupon code"
                                    value="{{ $coupon['code'] ?? '' }}" {{ $coupon ? 'disabled' : '' }}
                                    class="flex-1 min-w-0 border-2 border-gray-200 rounded px-3 py-2 text-xs outline-none focus:border-purple-500 transition placeholder-gray-300 uppercase {{ $coupon ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}">
                                <button id="applyCouponBtn" onclick="applyCoupon()" {{ $coupon ? 'disabled' : '' }}
                                    class="bg-gray-900 hover:bg-purple-700 text-white text-xs font-bold px-3 py-2 rounded transition shrink-0 {{ $coupon ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    Apply
                                </button>
                            </div>
                            <p id="couponMsg" class="text-xs mt-1.5"></p>
                        </div>

                    </div>

                    <div class="mt-4 text-center space-y-2">
                        <p class="text-xs text-gray-400 flex items-center justify-center gap-1.5">
                            <i class="fa fa-shield-alt text-green-500"></i>30-Day Money-Back Guarantee
                        </p>
                        <p class="text-xs text-gray-400 flex items-center justify-center gap-1.5">
                            <i class="fa fa-lock text-purple-500"></i>Secure SSL Checkout
                        </p>
                    </div>

                    <div class="mt-4 flex justify-center gap-2 flex-wrap">
                        @foreach (['💳 Visa', '💳 Mastercard', '🏦 UPI', '📱 Paytm'] as $pay)
                            <span
                                class="bg-gray-50 border border-gray-200 text-[10px] text-gray-500 px-2 py-1 rounded font-medium">{{ $pay }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Sticky Checkout --}}
    <div
        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 flex items-center gap-3 z-50 shadow-2xl">
        <div class="flex-1">
            <div id="mobileTotal" class="font-sora font-extrabold text-lg text-gray-900">
                ${{ number_format($subTotal) }}</div>
            <div class="text-xs text-gray-400">{{ $cartItems->count() }} course{{ $cartItems->count() !== 1 ? 's' : '' }}
            </div>
        </div>
        <a href="{{ url('/checkout') }}"
            class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded text-sm transition">
            Checkout →
        </a>
    </div>
    <div class="lg:hidden h-20"></div>

@endsection

@push('scripts')
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        //=============== Remove Cart Item:===============

        document.querySelectorAll('.remove-btn').forEach(btn => {

            btn.addEventListener('click', function() {

                const item = this.closest('.cart-item');
                const courseId = item.dataset.courseId;

                fetch(`/cart/${courseId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.success) {

                            item.style.transition = "all 0.3s ease";
                            item.style.opacity = "0";
                            item.style.transform = "translateX(-20px)";

                            setTimeout(() => {
                                location.reload();
                            }, 300);

                        } else {
                            alert(data.message);
                        }
                    });

            });

        });


        // ================= APPLY COUPON =================
        async function applyCoupon() {

            const input = document.getElementById('couponInput');
            const messageBox = document.getElementById('couponMsg');
            const code = input.value.trim();

            if (!code) {
                messageBox.textContent = "Please enter a coupon code.";
                messageBox.className = "text-xs mt-1.5 text-red-500";
                return;
            }

            try {

                const response = await fetch("{{ route('cart.coupon.apply') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": CSRF,
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        coupon_code: code
                    })
                });

                const data = await response.json();

                if (!data.success) {
                    messageBox.textContent = data.message;
                    messageBox.className = "text-xs mt-1.5 text-red-500";
                    return;
                }

                // ✅ Success UI Update
                messageBox.textContent = data.message;
                messageBox.className = "text-xs mt-1.5 text-green-600";

                const finalTotal = Number(data.final_total);
                document.getElementById("summaryTotal").textContent = "$" + finalTotal.toLocaleString("en-IN");
                document.getElementById("mobileTotal").textContent = "$" + finalTotal.toLocaleString("en-IN");

                // ✅ Coupon Row turant show karo
                const couponRow = document.getElementById("couponRow");
                const summaryCoupon = document.getElementById("summaryCoupon");
                summaryCoupon.textContent = Number(data.coupon_discount).toLocaleString("en-IN");
                couponRow.classList.remove("hidden");

                // ✅ You Save badge update karo
                const originalPrice = Number(document.getElementById('cartData').dataset.original);
                document.getElementById("youSaveBadge").textContent =
                    "🎉 You save $" + (originalPrice - finalTotal).toLocaleString("en-IN") + "!";

                // Input & button disable karo
                input.disabled = true;
                input.classList.add("bg-gray-100", "text-gray-400", "cursor-not-allowed");
                const applyBtn = document.getElementById("applyCouponBtn");
                applyBtn.disabled = true;
                applyBtn.classList.add("opacity-50", "cursor-not-allowed");

            } catch (error) {
                messageBox.textContent = "Something went wrong.";
                messageBox.className = "text-xs mt-1.5 text-red-500";
            }

        }
        document.getElementById('removeCouponBtn').addEventListener('click', async function() {

            try {
                const response = await fetch("{{ route('cart.coupon.remove') }}", {
                    method: "Delete",
                    headers: {
                        "X-CSRF-TOKEN": CSRF,
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message);
                    return;
                }

                // =========Coupon Row hide=========
                document.getElementById("couponRow").classList.add("hidden");
                document.getElementById("summaryCoupon").textContent = "0";

                // =========Total update=========
                const finalTotal = Number(data.final_total);
                document.getElementById("summaryTotal").textContent = "$" + finalTotal.toLocaleString("en-IN");
                document.getElementById("mobileTotal").textContent = "$" + finalTotal.toLocaleString("en-IN");

                //   =========You Save badge update=========
                const originalPrice = Number(document.getElementById('cartData').dataset.original);
                document.getElementById("youSaveBadge").textContent =
                    "🎉 You save $" + (originalPrice - finalTotal).toLocaleString("en-IN") + "!";

                // =========Input & button re-enable=========
                const input = document.getElementById("couponInput");
                input.disabled = false;
                input.value = "";
                input.classList.remove("bg-gray-100", "text-gray-400", "cursor-not-allowed");

                const applyBtn = document.getElementById("applyCouponBtn");
                applyBtn.disabled = false;
                applyBtn.classList.remove("opacity-50", "cursor-not-allowed");

                // =========Message show=========
                const messageBox = document.getElementById("couponMsg");
                messageBox.textContent = "Coupon removed.";
                messageBox.className = "text-xs mt-1.5 text-green-600";

            } catch (error) {
                alert("Something went wrong.");
            }
        });
    </script>
@endpush
