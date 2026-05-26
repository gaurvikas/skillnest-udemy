<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseService
{
    public function create($request, $data)
    {
        try {
            $data['instructor_id'] = $data['instructor_id'] ?? auth()->id();
            $data['slug'] = Str::slug($data['title']);
            $course = Course::create($data);

            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                $course->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
            }

            return $course;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function syncCategories(Course $course, array $categories)
    {
        $course->categories()->sync($categories);
    }

    public function update(Request $request, Course $course, array $data): Course
    {
        try {

            if (isset($data['title']) && $data['title'] !== $course->title) {
                $data['slug'] = Str::slug($data['title']);
            }

            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {

                $course->clearMediaCollection('thumbnail');

                $course->addMediaFromRequest('thumbnail')
                    ->toMediaCollection('thumbnail');
            }

            $course->update($data);

            return $course->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function search($request)
    {

        $query = $request->query('query');
        if (! $query && $request->filled('category')) {
            $query = '*';
        }
        $query = $query ?? '*';

        $levels = $request->query('level', []);
        $ratings = $request->query('rating', []);
        $durations = $request->query('duration', []);
        if (! is_array($ratings)) {
            $ratings = [$ratings];
        }
        if (! is_array($levels)) {
            $levels = [$levels];
        }
        if (! is_array($durations)) {
            $durations = [$durations];
        }
        $filterBy = [];

        //    if ($request->filled('category')) {
        //         $categorySlug = $request->query('category');
        //         $category = Category::where('slug', $categorySlug)->first();
        //         if ($category) {
        //             $filterBy[] = "category_ids:=[{$category->id}]";
        //         }
        //     }
        // Category filter
        if ($request->filled('category')) {
            $categorySlug = $request->query('category');
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                // Check if a subcategory is also selected
                if ($request->filled('subcategory')) {
                    $subSlug = $request->query('subcategory');
                    $sub = Category::where('slug', $subSlug)
                        ->where('parent_id', $category->id)
                        ->first();
                    if ($sub) {
                        $filterBy[] = "category_ids:=[{$sub->id}]";
                    } else {
                        $filterBy[] = "category_ids:=[{$category->id}]";
                    }
                } else {
                    $filterBy[] = "category_ids:=[{$category->id}]";
                }
            }
        }

        // Rating filter
        if (! empty($ratings)) {
            $minRating = min($ratings);
            $filterBy[] = "average_rating:>={$minRating}";
        }
        // Level filter
        if (! empty($levels)) {
            $levelString = implode(',', $levels);
            $filterBy[] = "level:=[{$levelString}]";
        }
        // Duration filter
        if (! empty($durations)) {
            $rangeFilters = [];
            foreach ($durations as $duration) {
                if (str_contains($duration, '-')) {
                    [$start, $end] = array_map('trim', explode('-', $duration));
                    $rangeFilters[] = "duration:>={$start} && duration:<={$end}";
                }
            }
            if (! empty($rangeFilters)) {
                $filterBy[] = '('.implode(' || ', $rangeFilters).')';
            }
        }
        $filterQuery = implode(' && ', $filterBy);
        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */
        $sort = $request->query('sort');
        $sortBy = null;
        if ($sort == 'relevant') {
            $sortBy = '';
        }
        if ($sort == 'rating') {
            $sortBy = 'average_rating:desc';
        }
        if ($sort == 'reviews') {
            $sortBy = 'reviews_count:desc';
        }
        if ($sort == 'newest') {
            $sortBy = 'created_at:desc';
        }
        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        $courses = Course::search($query)
            ->options([
                'filter_by' => $filterQuery ?: null,
                'sort_by' => $sortBy ?: null,
            ])
            ->paginate(9)
            ->withQueryString();

        return $courses;
    }
}
