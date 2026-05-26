<x-layouts.app>

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __("Here's what's happening on your platform today.") }}</p>
    </div>

    {{-- ── Row 1: Stat Cards ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        {{-- Total Users --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Users') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                        {{ $users ?? '--' }}
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 dark:text-blue-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Revenue') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                        {{ isset($revenue) ? '$' . number_format($revenue, 2) : '--' }}
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 dark:text-green-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Enrollments --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Enrollments') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                        {{ $enrollments ?? '--' }}
                    </p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 dark:text-purple-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Courses --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Courses') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                        {{ $courses ?? '--' }}
                    </p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500 dark:text-orange-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Row 2: Line Chart + Donut Chart ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- User Signups Line Chart (spans 2 cols) --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                        {{ __('User Signups & Revenue') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('Last 6 months') }}</p>
                </div>
                <span
                    class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded">{{ now()->format('Y') }}</span>
            </div>
            <canvas id="signupsRevenueChart" height="110"></canvas>
        </div>

        {{-- Enrollment Distribution Donut --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                    {{ __('Enrollment by Category') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('All time distribution') }}</p>
            </div>
            <canvas id="enrollmentDonutChart" height="180"></canvas>
            <div class="mt-4 space-y-2" id="donutLegend"></div>
        </div>

    </div>

    {{-- ── Row 3: Bar Chart + Progress Table + Activity Feed ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Monthly Enrollments Bar Chart --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                        {{ __('Monthly Enrollments') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('New enrollments per month') }}
                    </p>
                </div>
            </div>
            <canvas id="enrollmentsBarChart" height="110"></canvas>
        </div>

        {{-- Recent Activity Feed --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ __('Recent Activity') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('Latest platform events') }}</p>
            </div>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            @if ($activity['icon'] === 'user')
                                <div
                                    class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @elseif($activity['icon'] === 'book')
                                <div
                                    class="w-7 h-7 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-purple-500 dark:text-purple-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @elseif($activity['icon'] === 'money')
                                <div
                                    class="w-7 h-7 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif($activity['icon'] === 'star')
                                <div
                                    class="w-7 h-7 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-yellow-500 dark:text-yellow-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                            @else
                                <div
                                    class="w-7 h-7 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-orange-500 dark:text-orange-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate">
                                {{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">
                        {{ __('No recent activity yet.') }}</p>
                @endforelse
            </div>
        </div>

    </div>


    {{-- ── Row 4: Top Courses Progress Table ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                    {{ __('Top Courses by Enrollment') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ __('Completion rate and enrollment count') }}</p>
            </div>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach ($topCourses as $course)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $course->title }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $course->categories->pluck('name')->join(', ') }}</p>
                    </div>
                    <div class="text-right w-20 flex-shrink-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                            {{ $course->enrollments_count }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">enrolled</p>
                    </div>
                    <div class="w-32 flex-shrink-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Completion') }}</span>
                            <span
                                class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ number_format($course->enrollments_avg_progress_percentage ?? 0) }}%</span>

                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full
                                @if (number_format($course->enrollments_avg_progress_percentage ?? 0) >= 70) bg-green-500
                                @elseif(number_format($course->enrollments_avg_progress_percentage ?? 0) >= 50) bg-blue-500
                                @else bg-orange-400 @endif"
                                style="width: {{ number_format($course->enrollments_avg_progress_percentage ?? 0) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            const labelColor = isDark ? '#9ca3af' : '#6b7280';
            const tooltipBg = isDark ? '#1f2937' : '#ffffff';
            const tooltipText = isDark ? '#f9fafb' : '#111827';

            Chart.defaults.font.family = "'Instrument Sans', sans-serif";
            Chart.defaults.font.size = 12;

            // ── 1. Signups & Revenue Line Chart ──────────────────────────────
            const signupsCtx = document.getElementById('signupsRevenueChart').getContext('2d');

            new Chart(signupsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},

                    datasets: [{
                            label: 'New Users',
                            data: {!! json_encode($userData) !!},
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.08)',
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#3b82f6',
                            fill: true,
                            tension: 0.4,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Revenue ($)',
                            data: {!! json_encode($revenueData) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16,185,129,0.08)',
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#10b981',
                            fill: true,
                            tension: 0.4,
                            yAxisID: 'y1',
                        }
                    ]
                },

                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: labelColor,
                                boxWidth: 12,
                                padding: 16
                            }
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,
                            borderColor: gridColor,
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor
                            }
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor
                            },
                            title: {
                                display: true,
                                text: 'Users',
                                color: labelColor
                            }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                color: labelColor,
                                callback: v => '$' + v
                            },
                            title: {
                                display: true,
                                text: 'Revenue',
                                color: labelColor
                            }
                        }
                    }
                }
            });

            // ── 2. Enrollment Donut Chart ─────────────────────────────────────
            const donutCtx = document.getElementById('enrollmentDonutChart').getContext('2d');
            const donutLabels = {!! json_encode($donutLabels) !!};
            const donutData = {!! json_encode($donutData) !!};
            const donutColors = ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'];

            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: donutLabels,
                    datasets: [{
                        data: donutData,
                        backgroundColor: donutColors,
                        borderWidth: 2,
                        borderColor: isDark ? '#1f2937' : '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,
                            borderColor: gridColor,
                            borderWidth: 1
                        }
                    }
                }
            });

            // Build custom legend
            const legend = document.getElementById('donutLegend');
            donutLabels.forEach((label, i) => {
                legend.innerHTML += `
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:${donutColors[i]}"></span>
                            <span class="text-gray-600 dark:text-gray-400">${label}</span>
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">${donutData[i]}%</span>
                    </div>`;
            });

            // ── 3. Monthly Enrollments Bar Chart ─────────────────────────────
            const barCtx = document.getElementById('enrollmentsBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($enrollmentLabels) !!},
                    datasets: [{
                        label: 'New Enrollments',
                        data: {!! json_encode($enrollmentData) !!},
                        backgroundColor: 'rgba(139,92,246,0.8)',
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: labelColor,
                                boxWidth: 12,
                                padding: 16
                            }
                        },
                        tooltip: {
                            backgroundColor: tooltipBg,
                            titleColor: tooltipText,
                            bodyColor: tooltipText,
                            borderColor: gridColor,
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                color: labelColor
                            }
                        }
                    }
                }
            });

        });
    </script>

</x-layouts.app>
