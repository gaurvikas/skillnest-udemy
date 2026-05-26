@extends('frontend.layouts.app')
@section('title', $course->title . ' - SkillNest')
@section('content')

    {{-- HERO --}}

    <div class="bg-gray-900 text-white py-8 sm:py-10 px-4 sm:px-8 md:px-12">
        <div class="max-w-7xl mx-auto">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs text-white/60 mb-4 flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ url('/courses') }}" class="hover:text-white transition">Development</a>
                <span>/</span>
                <span class="text-white/80">Python</span>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1">
                    <h1 class="font-sora text-2xl sm:text-3xl font-extrabold leading-tight mb-3">
                        {{ $course->title }}
                    </h1>
                    <p class="text-white/75 text-sm sm:text-base leading-relaxed mb-5">
                        {{ $course->description }}
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-amber-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded">Bestseller</span>
                        <span class="bg-white/10 text-white/80 text-xs px-2.5 py-1 rounded">Updated Jan 2024</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3 flex-wrap">
                        <span
                            class="text-amber-400 font-bold text-lg">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</span>
                        <span class="text-amber-400">★★★★★</span>
                        <span class="text-white/60 text-sm underline cursor-pointer">
                            ({{ $course->reviews()->count() ?? 0 }})</span>
                        <span class="text-white/60 text-sm">• {{ $course->enrollments->count() }} students</span>
                    </div>
                    <p class="text-sm text-white/70 mb-3">
                        By <a href="#" class="text-purple-300 underline"> {{ $course->instructor->name }}</a>
                    </p>
                    <div class="flex flex-wrap gap-3 sm:gap-5 text-xs text-white/60">
                        <span><i class="fa fa-clock mr-1"></i> Last updated
                            {{ $course->updated_at->format('d M Y') }}</span>
                        <span><i class="fa fa-globe mr-1"></i>English</span>
                        <span><i class="fa fa-closed-captioning mr-1"></i>CC available</span>
                    </div>
                </div>

                {{-- Mobile Purchase Card --}}
                <div class="lg:hidden border border-white/20 rounded overflow-hidden bg-white/5 backdrop-blur">
                    <div
                        class="h-36 bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center text-xs relative">
                        <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: asset('images/default-course.png') }}" alt="{{ $course->title }}" class="w-full h-full object-cover">


                        <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                            <div
                                class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center cursor-pointer hover:bg-white/30 transition">
                                <i class="fa fa-play text-white ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        @if ($isPurchased)
                            {{-- ===== PURCHASED ===== --}}
                            <div
                                class="flex items-center gap-2 bg-green-500/20 border border-green-400/30 rounded px-4 py-3 mb-4">
                                <i class="fa fa-check-circle text-green-400 text-lg"></i>
                                <div>
                                    <p class="text-sm font-bold text-green-300">You own this course</p>
                                    <p class="text-xs text-green-400/70">Enjoy full lifetime access</p>
                                </div>
                            </div>
                            <a href="{{ route('course.learn', $course->slug) }}"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded text-sm mb-3 transition flex items-center justify-center gap-2">
                                <i class="fa fa-play-circle"></i> Go to Course
                            </a>
                        @elseif($inCart)
                            <div class="flex items-baseline gap-3 mb-1">
                                <span
                                    class="font-sora text-2xl font-extrabold text-white">${{ number_format($course->original_price ?? 0) }}</span>
                                <span
                                    class="text-sm text-white/50 line-through">${{ number_format($course->price ?? 0) }}</span>
                                <span class="text-sm text-green-400 font-semibold">86% off</span>
                            </div>
                            <p class="text-xs text-red-400 font-semibold mb-4">⏰ 2 days left at this price!</p>
                            <a href="{{ route('cart.index') }}"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded text-sm mb-3 transition flex items-center justify-center gap-2">
                                <i class="fa fa-shopping-cart"></i> Go to Cart
                            </a>
                            <button onclick="window.location.href='{{ route('buy.index', $course->id) }}'"
                                class="w-full border-2 border-white text-white font-bold py-3 rounded text-sm mb-3 hover:bg-white hover:text-gray-900 transition">
                                Buy Now
                            </button>
                            <p class="text-center text-xs text-white/50">30-Day Money-Back Guarantee</p>
                        @else
                            {{-- ===== DEFAULT ===== --}}
                            <div class="flex items-baseline gap-3 mb-1">
                                <span
                                    class="font-sora text-2xl font-extrabold text-white">${{ number_format($course->original_price ?? 0) }}</span>
                                <span
                                    class="text-sm text-white/50 line-through">${{ number_format($course->price ?? 0) }}</span>
                                <span class="text-sm text-green-400 font-semibold">86% off</span>
                            </div>
                            <p class="text-xs text-red-400 font-semibold mb-4">⏰ 2 days left at this price!</p>
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded text-sm mb-3 transition">
                                    Add to Cart
                                </button>
                            </form>
                            <button onclick="window.location.href='{{ route('buy.index', $course->id) }}'"
                                class="w-full border-2 border-white text-white font-bold py-3 rounded text-sm mb-3 hover:bg-white hover:text-gray-900 transition">
                                Buy Now
                            </button>
                            <p class="text-center text-xs text-white/50">30-Day Money-Back Guarantee</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MAIN --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8 flex flex-col lg:flex-row gap-8 items-start">

        {{-- LEFT --}}
        <div class="flex-1 min-w-0 w-full">

            {{-- What You'll Learn --}}
            <div class="border border-gray-200 rounded p-5 sm:p-7 mb-8">
                <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900 mb-5">What you'll learn</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach (['Python 3 fundamentals & syntax', 'Object-Oriented Programming (OOP)', 'Build real-world applications', 'Web scraping with BeautifulSoup', 'Work with Jupyter Notebooks', 'Data analysis with Pandas & NumPy', 'GUI programs with Python', 'Connect Python to databases'] as $point)
                        <div class="flex items-start gap-2.5 text-sm text-gray-600">
                            <i class="fa fa-check text-purple-500 mt-0.5 shrink-0 text-xs"></i>
                            <span>{{ $point }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Curriculum --}}
            <div class="mb-8">
                <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900 mb-2">Course Curriculum</h2>
                <p class="text-sm text-gray-400 mb-5"> {{ $course->sections->sum(fn($s) => $s->lessons->count()) }}
                    lectures
                </p>
                <div class="border border-gray-200 rounded overflow-hidden divide-y divide-gray-100">
                    @foreach ($course->sections as $section)
                        <details class="group">
                            <summary
                                class="flex items-center justify-between px-4 sm:px-5 py-4 cursor-pointer hover:bg-gray-50 transition list-none">
                                <div class="flex items-center gap-3 min-w-0">
                                    <i
                                        class="fa fa-chevron-right text-xs text-gray-400 group-open:rotate-90 transition-transform shrink-0"></i>
                                    <span class="font-semibold text-sm text-gray-900 truncate">
                                        {{ $section->title }}</span>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0 ml-3"> {{ $section->lessons->count() }}
                                    lectures</span>
                            </summary>
                            <div class="bg-gray-50 px-6 sm:px-8 py-4 space-y-2.5">
                                @foreach ($section->lessons as $lesson)
                                    <div class="flex items-center gap-3 text-sm text-gray-600">

                                        @if ($isPurchased || $lesson->is_preview == true)
                                            <a href="javascript:void(0);"
                                                onclick="openVideoModal('{{ $lesson->getFirstMediaUrl('video') }}')">
                                                <i class="fa fa-play-circle text-purple-400 shrink-0"></i>
                                            </a>
                                        @else
                                            <i class="fa fa-lock text-gray-400 shrink-0"></i>
                                        @endif

                                        <span>Lecture {{ $lesson->title }}</span>

                                        <div class="ml-auto flex items-center gap-2">

                                            @if ($lesson->is_preview)
                                                <span
                                                    class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">
                                                    Preview
                                                </span>
                                            @endif

                                            <span class="text-xs text-gray-400 shrink-0">
                                                {{ $lesson->formattedDuration }}
                                            </span>

                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>

            {{-- Instructor --}}
            <div>
                <h2 class="font-sora font-bold text-base sm:text-lg text-gray-900 mb-5">Instructor</h2>
                <div class="flex flex-col sm:flex-row items-start gap-5">
                    <div
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center text-white font-bold text-lg shrink-0">
                        {{ $course->instructor->initials() }}</div>
                    <div>
                        <h3 class="font-bold text-purple-600 text-base hover:underline cursor-pointer mb-1">
                            {{ $course->instructor->name }}
                        </h3>
                        <p class="text-sm text-gray-400 mb-3">Head of Data Science, Pierian Training</p>
                        <div class="flex flex-wrap gap-3 sm:gap-5 text-sm text-gray-600 mb-3">
                            <span><i class="fa fa-star text-amber-400 mr-1"></i>4.7 Rating</span>
                            <span>
                                <i class="fa fa-users text-purple-400 mr-1"></i>
                                {{ $course->enrollments->count() }} Students
                            </span>
                            <span>
                                <i
                                    class="fa fa-play-circle text-purple-400 mr-1"></i>{{ $course->instructor->courses->count() }}
                                Courses
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed max-w-xl">
                            Jose has a BS and MS in Mechanical Engineering from Santa Clara University and works as a Data
                            Scientist and Bootcamp Instructor.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT sticky card — desktop only --}}
        <div class="hidden lg:block w-80 shrink-0">
            <div class="sticky top-20 border border-gray-200 rounded overflow-hidden shadow-xl">
                <div
                    class="h-44 bg-gradient-to-br from-violet-500 to-purple-800 flex items-center justify-center text-6xl relative">
                    <img src="{{ $course->getFirstMediaUrl('thumbnail') ?: asset('images/default-course.png') }}" alt="{{ $course->title }}"
                        class="w-full h-full object-cover font-semibold text-xs">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                        <div
                            class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center cursor-pointer hover:bg-white/30 transition">
                            <i class="fa fa-play text-white text-xl ml-1"></i>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($isPurchased)
                        {{-- ========== PURCHASED STATE ========== --}}
                        <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded px-4 py-3 mb-4">
                            <i class="fa fa-check-circle text-green-500 text-lg"></i>
                            <div>
                                <p class="text-sm font-bold text-green-700">You own this course</p>
                                <p class="text-xs text-green-500">Enjoy full lifetime access</p>
                            </div>
                        </div>

                        <a href="{{ route('course.learn', $course->slug) }}"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded text-sm mb-3 transition flex items-center justify-center gap-2">
                            <i class="fa fa-play-circle"></i> Go to Course
                        </a>
                    @elseif($inCart)
                        {{-- Cart mein hai --}}
                        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded px-4 py-3 mb-4">
                            <i class="fa fa-shopping-cart text-blue-500 text-lg"></i>
                            <div>
                                <p class="text-sm font-bold text-blue-700">Already in your cart</p>
                                <p class="text-xs text-blue-500">Complete your purchase</p>
                            </div>
                        </div>

                        <a href="{{ route('cart.index') }}"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded text-sm mb-3 transition flex items-center justify-center gap-2">
                            <i class="fa fa-shopping-cart"></i> Go to Cart
                        </a>
                        <button type="button" onclick="window.location.href='{{ route('buy.index', $course->id) }}'"
                            class="w-full border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold py-3.5 rounded text-sm mb-5 transition">
                            Buy Now
                        </button>
                    @else
                        {{-- Normal purchase state — aapka existing form same rahega --}}
                        <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <div class="flex items-baseline gap-3 mb-1">
                                <span
                                    class="font-sora text-3xl font-extrabold text-gray-900">{{ $course->priceInr }}</span>
                                <span class="text-sm text-gray-400 line-through">${{ $course->original_price }}</span>
                                <span class="text-sm text-green-600 font-semibold">{{ $course->priceDiscount }} off</span>
                            </div>
                            <p class="text-xs text-red-500 font-semibold mb-4">⏰ 2 days left at this price!</p>

                            <button id="addToCartBtn"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded text-sm mb-3 transition">
                                Add to Cart
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('buy.index', $course->id) }}'"
                                class="w-full border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold py-3.5 rounded text-sm mb-5 transition">
                                Buy Now
                            </button>
                            <p class="text-center text-xs text-gray-400 mb-5">30-Day Money-Back Guarantee</p>
                        </form>
                    @endif

                    {{-- ========== ALWAYS VISIBLE ========== --}}
                    <h4 class="font-semibold text-sm text-gray-900 mb-3">This course includes:</h4>
                    <div class="space-y-2">
                        @foreach ([['fa-video', '22 hours on-demand video'], ['fa-file-alt', '18 articles'], ['fa-download', 'Downloadable resources'], ['fa-mobile-alt', 'Access on mobile & TV'], ['fa-infinity', 'Full lifetime access'], ['fa-certificate', 'Certificate of completion']] as $inc)
                            <div class="flex items-center gap-2.5 text-xs text-gray-600">
                                <i class="fa {{ $inc[0] }} text-purple-500 w-4 text-center shrink-0"></i>
                                <span>{{ $inc[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile sticky buy bar --}}
    <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        {{-- Mobile sticky buy bar --}}
        <div
            class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 flex items-center gap-3 z-50 shadow-2xl">
            <div>
                <span class="font-sora font-extrabold text-xl text-gray-900">
                    {{ $course->priceInr }}
                </span>
                <span class="text-xs text-gray-400 line-through ml-2">
                    ${{ number_format($course->original_price ?? 0) }}
                </span>
            </div>

            @if ($isPurchased)
                <a href="{{ route('course.learn', $course->slug) }}"
                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded text-sm transition text-center">
                    <i class="fa fa-play mr-1"></i> Go to Course
                </a>
            @elseif($inCart)
                <a href="{{ route('cart.index') }}"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded text-sm transition text-center">
                    <i class="fa fa-shopping-cart mr-1"></i> Go to Cart
                </a>
                <a href="{{ route('buy.index', $course->id) }}"
                    class="flex-1 border-2 border-gray-900 text-gray-900 font-bold py-3 rounded text-sm hover:bg-gray-900 hover:text-white transition text-center">
                    Buy Now
                </a>
            @else
                <form action="{{ route('cart.store') }}" method="POST" class="flex gap-3 flex-1">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded text-sm transition">
                        Add to Cart
                    </button>
                </form>
                <button onclick="window.location.href='{{ route('buy.index', $course->id) }}'"
                    class="flex-1 border-2 border-gray-900 text-gray-900 font-bold py-3 rounded text-sm hover:bg-gray-900 hover:text-white transition">
                    Buy Now
                </button>
            @endif
        </div>
    </form>

    <div class="lg:hidden h-20"></div>
    <!-- VIDEO MODAL -->
    <div id="videoModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300">

        <div class="relative bg-white w-11/12 md:w-3/4 lg:w-1/2 rounded overflow-hidden shadow-2xl">

            <!-- Close Button -->
            <button onclick="closeVideoModal()" class="absolute top-3 right-3 text-white text-xl font-bold">
                ✕
            </button>

            <!-- Video -->
            <video id="modalVideo" controls class="w-full h-auto">
                <source id="videoSource" src="" type="video/mp4">
            </video>

        </div>
    </div>
    <script>
        function openVideoModal(videoUrl) {
            document.getElementById('videoSource').src = videoUrl;
            document.getElementById('modalVideo').load();
            document.getElementById('videoModal').classList.remove('hidden');
            document.getElementById('videoModal').classList.add('flex');
        }

        function closeVideoModal() {
            document.getElementById('modalVideo').pause();
            document.getElementById('videoModal').classList.add('hidden');
            document.getElementById('videoModal').classList.remove('flex');
        }
    </script>
@endsection
