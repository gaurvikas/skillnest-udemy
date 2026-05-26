<section class="relative overflow-hidden min-h-[520px] flex items-center px-6 sm:px-10 md:px-16 py-16 md:py-20"
    style="background: linear-gradient(135deg, #1c1d1f 0%, #2d1457 55%, #a435f0 100%);">

    {{-- Blobs --}}
    <div class="absolute -top-20 -right-20 w-72 h-72 sm:w-96 sm:h-96 lg:w-[520px] lg:h-[520px] rounded-full pointer-events-none opacity-70"
        style="background: radial-gradient(circle, rgba(244,196,48,0.20) 0%, transparent 70%);"></div>
    <div class="absolute -bottom-24 -left-16 w-64 h-64 sm:w-80 sm:h-80 lg:w-[420px] lg:h-[420px] rounded-full pointer-events-none"
        style="background: radial-gradient(circle, rgba(164,53,240,0.28) 0%, transparent 70%);"></div>
    <div class="absolute top-1/3 left-1/2 w-40 h-40 lg:w-[260px] lg:h-[260px] rounded-full pointer-events-none opacity-40"
        style="background: radial-gradient(circle, rgba(56,189,248,0.18) 0%, transparent 70%);"></div>

    {{-- Dot grid --}}
    <div class="absolute inset-0 pointer-events-none opacity-20"
        style="background-image: radial-gradient(rgba(255,255,255,0.5) 1px, transparent 1px);
               background-size: 28px 28px;
               mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
               -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);">
    </div>

    {{-- Main layout: text left, stats right on xl --}}
    <div class="relative z-10 w-full flex flex-col xl:flex-row xl:items-center xl:justify-between gap-12">

        {{-- ░░ LEFT: Text Content ░░ --}}
        <div class="w-full xl:max-w-xl text-white">

            {{-- Eyebrow --}}
            <div
                class="inline-flex items-center gap-2 bg-white/10 border border-white/20 backdrop-blur-sm
                        text-amber-300 text-xs font-semibold tracking-widest uppercase px-4 py-1.5 rounded-full mb-6
                        animate-fade-in opacity-0 [animation-delay:100ms] [animation-fill-mode:forwards]">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                World's #1 Learning Platform
            </div>

            {{-- Headline --}}
            <h1
                class="font-sora font-extrabold leading-[1.08] tracking-tight mb-5
                       text-4xl sm:text-5xl lg:text-6xl
                       animate-fade-in opacity-0 [animation-delay:200ms] [animation-fill-mode:forwards]">
                Learn Without
                <span class="text-amber-400" style="text-shadow: 0 0 32px rgba(251,191,36,0.35);">Limits.</span><br>
                Grow Without
                <span class="text-white/40">Bounds.</span>
            </h1>

            {{-- Subheading --}}
            <p
                class="text-base sm:text-lg leading-relaxed text-white/70 mb-8 max-w-md
                      animate-fade-in opacity-0 [animation-delay:300ms] [animation-fill-mode:forwards]">
                Join 57 million learners worldwide. Explore top-rated courses in tech,
                business, design, and beyond — taught by real-world experts.
            </p>

            {{-- CTAs --}}
            <div
                class="flex flex-wrap items-center gap-3 mb-8
                        animate-fade-in opacity-0 [animation-delay:400ms] [animation-fill-mode:forwards]">
                <a href="{{ route('my-learning.index') }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-gray-900
                           font-bold text-sm px-6 py-3 rounded
                           transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-amber-400/30
                           active:translate-y-0 active:shadow-none">
                    Start Learning Free
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm font-medium
                           border border-white/20 hover:border-white/40 px-6 py-3 rounded
                           transition-all duration-200 hover:bg-white/5 backdrop-blur-sm
                           active:bg-white/10">
                    Browse Courses
                </a>
            </div>

            {{-- Trust row --}}
            <div
                class="flex flex-wrap items-center gap-3
                        animate-fade-in opacity-0 [animation-delay:500ms] [animation-fill-mode:forwards]">
                <div class="flex -space-x-2">
                    @foreach (['bg-purple-500', 'bg-pink-500', 'bg-blue-500', 'bg-emerald-500', 'bg-orange-400'] as $color)
                        <div class="w-7 h-7 rounded-full border-2 border-purple-900 {{ $color }}"></div>
                    @endforeach
                </div>
                <div class="flex items-center gap-1">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-3 h-3 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-white/50 text-xs">
                    4.8 avg · <span class="text-white/80 font-semibold">12K joined this week</span>
                </span>
            </div>

        </div>

        {{-- ░░ RIGHT: Stats Cards ░░ --}}
        {{-- On mobile/tablet: horizontal row. On xl: vertical column --}}
        <div class="flex flex-row flex-wrap xl:flex-col gap-3 xl:gap-4 xl:min-w-[220px]">

            @foreach ([['57M+', 'Learners Worldwide', 'M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M9 4H7a2 2 0 00-2 2v12a2 2 0 002 2h2m4-16v16'], ['210K+', 'Online Courses', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13'], ['68K+', 'Expert Instructors', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z']] as $i => [$num, $label, $path])
                <div class="group flex items-center gap-3 xl:gap-4
                            bg-white/[0.07] hover:bg-white/[0.13] backdrop-blur-md
                            border border-white/[0.12] hover:border-white/25
                            rounded px-4 py-3 xl:px-6 xl:py-4
                            flex-1 min-w-[130px] xl:min-w-0 xl:w-full
                            opacity-0 transition-all duration-300 hover:-translate-y-1 cursor-default
                            animate-slide-in-right [animation-fill-mode:forwards]"
                    style="animation-delay: {{ 500 + $i * 150 }}ms">

                    <div
                        class="w-9 h-9 xl:w-10 xl:h-10 rounded bg-amber-400/10
                                flex items-center justify-center flex-shrink-0
                                group-hover:bg-amber-400/20 transition-colors duration-300">
                        <svg class="w-4 h-4 xl:w-5 xl:h-5 text-amber-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}" />
                        </svg>
                    </div>

                    <div>
                        <div class="font-sora text-xl xl:text-2xl font-extrabold text-amber-400 leading-none">
                            {{ $num }}
                        </div>
                        <div class="text-[11px] xl:text-xs text-white/55 mt-0.5 font-medium leading-tight">
                            {{ $label }}
                        </div>
                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>

{{-- Tailwind animation utilities --}}
<style>
    @layer utilities {
        .animate-fade-in {
            animation: fadeIn 0.6s ease both;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(24px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
