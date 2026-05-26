<a href="{{ route('courses.show', $course->slug) }}" class="block">
    <div
        class="border border-gray-200 rounded overflow-hidden bg-white cursor-pointer
                hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

        <div class="relative h-32 sm:h-36 overflow-hidden rounded-t">

            <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: asset('images/default-course.png') }}"
                alt="{{ $course->title }}" class="w-full h-full object-cover">

            @if ($badge)
                <span
                    class="absolute top-2 left-2 bg-amber-400 text-gray-900 text-[10px] font-bold px-2 py-0.5 rounded uppercase z-10">
                    {{ $badge }}
                </span>
            @endif

        </div>

        <div class="p-3 sm:p-3.5">

            <h3 class="font-sora font-semibold text-xs sm:text-sm leading-snug text-gray-900 line-clamp-2 mb-1.5">
                {{ $course->title }}
            </h3>

            <p class="text-[11px] text-gray-500 mb-2">
                {{ $course->instructor->name }}
            </p>

            <div class="flex items-center gap-1 mb-2">
                <span class="font-bold text-xs text-amber-700">
                    {{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}
                </span>
                <span class="text-[10px] text-gray-400">
                    ({{ $course->reviews()->count() ?? 0 }})
                </span>
            </div>

            <div class="flex gap-2 text-[10px] sm:text-[11px] text-gray-400 mb-2.5 flex-wrap">
                <span>{{ $course->duration }}h</span>
                <span>{{ $course->level }}</span>
            </div>

            <div class="flex items-center gap-1.5 flex-wrap">
                <span class="font-sora font-bold text-sm sm:text-base text-gray-900">
                    {{ $course->priceInr }}
                </span>
                <span class="text-sm text-gray-400 line-through">${{ number_format($course->original_price) }}</span>
            </div>

        </div>
    </div>
</a>
