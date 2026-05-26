@extends('frontend.pages.instructor.layout')
@section('title', 'Dashboard - Instructor')
@section('content')

    <div class="min-h-screen bg-gray-50">

        {{-- Page Header --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="font-sora text-xl sm:text-2xl font-bold">Dashboard</h1>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">

                {{-- Total Students --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6 hover:shadow-md transition" data-reveal>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">{{ $totalStudents }}</h3>
                    <p class="text-sm text-gray-600">Total Students</p>
                </div>
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
                    data-reveal>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                        @if (auth()->user()->instructorStripeAccount?->payouts_enabled)
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">
                                <i class="fas fa-circle text-green-500 text-xs mr-1"></i>Connected
                            </span>
                        @else
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded">
                                <i class="fas fa-circle text-amber-500 text-xs mr-1"></i>Not Connected
                            </span>
                        @endif
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">
                        ${{ number_format($instructorRevenue, 2 ?? 0) }}
                    </h3>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                </div>

                {{-- Active Courses --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
                    data-reveal>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $totalCourses }}
                            total</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">{{ $activeCourses }}</h3>
                    <p class="text-sm text-gray-600">Active Courses</p>
                </div>

                {{-- Average Rating --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
                    data-reveal>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded flex items-center justify-center">
                            <i class="fas fa-star text-amber-500 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+0.3</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">
                        {{ number_format($averageRating, 1) ?? '0.0' }}</h3>
                    <p class="text-sm text-gray-600">Average Rating</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6 mb-8">

                {{-- Revenue Chart --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                    data-reveal>

                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Revenue overview</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Last 7 days</p>
                        </div>
                        <span
                            class="text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-1 rounded-md">
                            This week
                        </span>
                    </div>

                    {{-- Total + Legend --}}
                    @php
                        $weekTotal = collect($revenueChart)->sum('amount');
                        $maxAmount = collect($revenueChart)->max('amount') ?: 1;
                        $bestDay = collect($revenueChart)->sortByDesc('amount')->first();
                        $activeDays = collect($revenueChart)->where('amount', '>', 0)->count();
                    @endphp

                    <div class="flex items-center justify-between mb-5">
                        <p class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                            ${{ number_format($weekTotal, 2) }}
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-sm bg-indigo-600 inline-block"></span>Today
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span
                                    class="w-2.5 h-2.5 rounded-sm bg-indigo-200 dark:bg-indigo-900 inline-block"></span>Past
                                days
                            </span>
                        </div>
                    </div>

                    {{-- Chart Canvas --}}
                    <div style="position:relative;width:100%;height:200px;">
                        <canvas id="revenueChart"></canvas>
                    </div>

                    {{-- Footer Stats --}}
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 dark:border-gray-700 mt-5 pt-5">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Best day</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $bestDay['day'] ?? '—' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Daily avg</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                ${{ number_format($weekTotal / 7, 2) }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Active days</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ $activeDays }}/7
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Quick Actions --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6" data-reveal>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h2>
                    <div class="space-y-3">
                        @php $stripeAccount = auth()->user()->instructorStripeAccount; @endphp

                        @if (!$stripeAccount)
                            <a href="{{ route('instructor.stripe.onboard') }}"
                                class="flex items-center gap-3 p-3 rounded border-2 border-dashed border-orange-300 hover:border-orange-400 hover:bg-orange-50 transition">
                                <div class="w-10 h-10 bg-orange-100 rounded flex items-center justify-center">
                                    <i class="fas fa-credit-card text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">Connect Stripe</p>
                                    <p class="text-xs text-orange-600 font-medium">Setup to receive payments</p>
                                </div>
                            </a>
                        @elseif(!$stripeAccount->payouts_enabled)
                            {{-- Connected but pending --}}
                            <a href="{{ route('instructor.stripe.onboard') }}"
                                class="flex items-center gap-3 p-3 rounded border-2 border-amber-300 hover:border-amber-400 hover:bg-amber-50 transition">
                                <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center">
                                    <i class="fas fa-clock text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">Complete Stripe Setup</p>
                                    <p class="text-xs text-amber-600 font-medium">Verification pending...</p>
                                </div>
                            </a>
                        @else
                            {{-- Active ✅ --}}
                            <a href="{{ route('instructor.stripe.dashboard') }}"
                                class="flex items-center gap-3 p-3 rounded border-2 border-green-300 hover:border-green-400 hover:bg-green-50 transition">
                                <div class="w-10 h-10 bg-green-100 rounded flex items-center justify-center">
                                    <i class="fas fa-wallet text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">Stripe Dashboard</p>
                                    <p class="text-xs text-green-600 font-medium">View earnings & payouts</p>
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('instructor.create') }}"
                            class="flex items-center gap-3 p-3 rounded border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition">
                            <div class="w-10 h-10 bg-purple-100 rounded flex items-center justify-center">
                                <i class="fas fa-plus text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Create Course</p>
                                <p class="text-xs text-gray-600">Start a new course</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition">
                            <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fas fa-bullhorn text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Send Announcement</p>
                                <p class="text-xs text-gray-600">Notify your students</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 transition">
                            <div class="w-10 h-10 bg-green-100 rounded flex items-center justify-center">
                                <i class="fas fa-chart-line text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">View Reports</p>
                                <p class="text-xs text-gray-600">Detailed analytics</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Activity & Top Courses --}}
            <div class="grid lg:grid-cols-2 gap-6">

                {{-- Recent Activity --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6" data-reveal>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Recent Activity</h2>
                    <div class="space-y-4">
                        @foreach ($enrollments as $enroll)
                            <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition">
                                <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center shrink-0">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">{{ $enroll->user->name }} enrolled in
                                        {{ $enroll->course->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $enroll->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($discussions as $discussion)
                            <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition">
                                <div class="w-10 h-10 bg-purple-100 rounded flex items-center justify-center shrink-0">
                                    <i class="fas fa-question-circle text-purple-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">New question in {{ $discussion->course->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $discussion->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        @if ($reviews->count())
                            @foreach ($reviews as $review)
                                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition">
                                    <div
                                        class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center shrink-0">
                                        <i class="fas fa-star text-amber-500"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">New review in {{ $review->course->title }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1"><strong>{{ $review->user->name }}</strong>
                                            rated {{ $review->rating }}/5</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">No reviews yet.</p>
                        @endif

                    </div>
                </div>

                {{-- Top Performing Courses --}}
                <div class="bg-white rounded shadow-sm border border-gray-200 p-6" data-reveal>
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Top Performing Courses</h2>
                    <div class="space-y-4">
                        @foreach ([['title' => 'Complete Web Development Bootcamp', 'students' => 456, 'revenue' => 22800, 'rating' => 4.8], ['title' => 'React - The Complete Guide', 'students' => 312, 'revenue' => 15600, 'rating' => 4.7], ['title' => 'Python for Data Science', 'students' => 289, 'revenue' => 14450, 'rating' => 4.9]] as $index => $course)
                            <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded transition">
                                <div
                                    class="w-8 h-8 bg-purple-600 text-white rounded flex items-center justify-center font-bold shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900 truncate">{{ $course['title'] }}</p>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-600">
                                        <span><i class="fas fa-users mr-1"></i>{{ $course['students'] }}</span>
                                        <span><i
                                                class="fas fa-rupee-sign mr-1"></i>{{ number_format($course['revenue']) }}</span>
                                        <span><i
                                                class="fas fa-star text-amber-500 mr-1"></i>{{ $course['rating'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Chart.js (add once in your layout if not already included) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const raw = {!! json_encode(
                collect($revenueChart)->map(
                        fn($d) => [
                            'day' => $d['day'],
                            'date' => $d['date'],
                            'amount' => $d['amount'],
                        ],
                    )->values(),
            ) !!};

            const todayIdx = raw.length - 1;
            const dark = document.documentElement.classList.contains('dark');
            const gridColor = dark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
            const lblColor = dark ? '#6b7280' : '#9ca3af';
            const todayHex = '#4F46E5';
            const pastHex = dark ? 'rgba(79,70,229,0.35)' : 'rgba(79,70,229,0.18)';
            const todayHov = '#3730A3';
            const pastHov = dark ? 'rgba(79,70,229,0.55)' : 'rgba(79,70,229,0.32)';

            new Chart(document.getElementById('revenueChart'), {
                type: 'bar',
                data: {
                    labels: raw.map(d => d.day),
                    datasets: [{
                        data: raw.map(d => d.amount),
                        backgroundColor: raw.map((_, i) => i === todayIdx ? todayHex : pastHex),
                        hoverBackgroundColor: raw.map((_, i) => i === todayIdx ? todayHov :
                            pastHov),
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: dark ? '#1f2937' : '#111827',
                            titleColor: '#f9fafb',
                            bodyColor: '#9ca3af',
                            padding: 10,
                            cornerRadius: 8,
                            borderWidth: 0,
                            callbacks: {
                                title: ctx => raw[ctx[0].dataIndex].date,
                                label: ctx => ' $' + ctx.parsed.y.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }),
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: ctx => ctx.index === todayIdx ? todayHex : lblColor,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: lblColor,
                                font: {
                                    size: 11
                                },
                                maxTicksLimit: 5,
                                callback: v => '$' + (v >= 1000 ? (v / 1000).toFixed(1) + 'k' : v)
                            }
                        }
                    }
                }
            });

        });
    </script>
@endsection
