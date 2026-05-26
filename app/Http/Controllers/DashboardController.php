<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $users = User::count();
        $courses = Course::count();
        $enrollments = Enrollment::count();

        $revenue = Cache::remember('total_revenue', 3600, function () {
            return (Order::sum('total') / 100) * 20;
        });

        $topCourses = Cache::remember('home_best_selling_courses', 3600, function () {
            return Course::with(['user', 'media', 'categories'])
                ->withAvg('reviews', 'rating')
                ->withAvg('enrollments', 'progress_percentage')
                ->withCount(['reviews', 'enrollments'])
                ->published()
                ->latest()
                ->orderByDesc('enrollments_count')
                ->limit(8)
                ->get();
        });

        // ==========Monthly Enrollments==========

        $monthlyEnrollments = Enrollment::selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($row) => "{$row->year}-{$row->month}");

        $enrollmentLabels = [];
        $enrollmentData = [];

        foreach (range(10, 0, -1) as $i) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-n');

            $enrollmentLabels[] = $date->format('M Y');
            $enrollmentData[] = (int) ($monthlyEnrollments[$key]->total ?? 0);
        }

        //  ==========Recent Activities==========

        $recentUsers = User::latest()->limit(5)->get()->map(fn ($u) => [
            'icon' => 'user',
            'color' => 'blue',
            'title' => "{$u->name} ".__('registered'),
            'time' => $u->created_at->diffForHumans(),
            'sort' => $u->created_at,
        ]);

        $recentEnrollments = Enrollment::with('course')
            ->latest()->limit(5)->get()->map(fn ($e) => [
                'icon' => 'book',
                'color' => 'purple',
                'title' => __('New User enrolled in').' '.optional($e->course)->title,
                'time' => $e->created_at->diffForHumans(),
                'sort' => $e->created_at,
            ]);

        $recentReviews = CourseReview::with('course')
            ->latest()->limit(5)->get()->map(fn ($r) => [
                'icon' => 'star',
                'color' => 'yellow',
                'title' => __('Reviewed').' '.optional($r->course)->title,
                'time' => $r->created_at->diffForHumans(),
                'sort' => $r->created_at,
            ]);

        $recentActivities = collect()
            ->merge($recentUsers)
            ->merge($recentEnrollments)
            ->merge($recentReviews)
            ->sortByDesc('sort')
            ->take(8)
            ->values();

        // ==========Users + Revenue Chart==========

        $monthlyUsers = User::selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($row) => "{$row->year}-{$row->month}");

        $monthlyRevenue = Order::selectRaw('YEAR(created_at) year, MONTH(created_at) month, SUM(total) total')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($row) => "{$row->year}-{$row->month}");

        $chartLabels = [];
        $userData = [];
        $revenueData = [];

        foreach (range(5, 0, -1) as $i) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-n');

            $chartLabels[] = $date->format('M');
            $userData[] = $monthlyUsers[$key]->total ?? 0;
            $revenueData[] = $monthlyRevenue[$key]->total ?? 0;
        }

        // ========== Category Donut Chart ==========

        $categoryData = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('category_course', 'courses.id', '=', 'category_course.course_id')
            ->join('categories', 'category_course.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(enrollments.id) total')
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        $donutLabels = $categoryData->pluck('name');
        $donutData = $categoryData->pluck('total');

        return view('dashboard', compact(
            'users',
            'courses',
            'revenue',
            'enrollments',
            'topCourses',
            'enrollmentLabels',
            'enrollmentData',
            'recentActivities',
            'chartLabels',
            'userData',
            'revenueData',
            'donutLabels',
            'donutData'
        ));
    }
}
