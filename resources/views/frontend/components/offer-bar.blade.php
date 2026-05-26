@if ($latestCoupon)
    <div id="promo-ticker" class="text-white text-sm font-medium text-center py-2 px-4 relative"
        style="background:#a435f0;">

        🎉 <strong>Special Offer:</strong>

        Apply coupon
        <strong onclick="navigator.clipboard.writeText('{{ $latestCoupon->code }}')">
            {{ $latestCoupon->code }}
        </strong>

        & get
        <strong>
            {{ $latestCoupon->type == 'percent' ? $latestCoupon->usage_limit . '%' : '$' . $latestCoupon->usage_limit }}
            OFF
        </strong>

        @if ($latestCoupon->expires_at)
            — Ends {{ \Carbon\Carbon::parse($latestCoupon->expires_at)->format('d M') }}
        @endif

        &nbsp;

        <a href="{{ route('courses.search') }}" class="font-bold underline hover:no-underline">
            Grab the deal →
        </a>

        <button onclick="document.getElementById('promo-ticker').style.display='none'"
            class="absolute right-5 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-base leading-none"
            aria-label="Close banner">
            &times;
        </button>
    </div>
@endif
