<?php

namespace App\Imports;

use App\Services\CourseService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoursesImport implements SkipsOnError, ToModel, WithHeadingRow, WithValidation
{
    use SkipsErrors;

    public function __construct(protected CourseService $courseService) {}

    public function model(array $row)
    {
        if (empty($row['title'])) {
            return null;
        }

        // ✅ CourseService::create() use kar rahe hain
        $course = $this->courseService->create(request(), [
            'instructor_id' => $row['instructor_id'] ?? null,
            'title' => $row['title'],
            'description' => $row['description'] ?? null,
            'original_price' => is_numeric($row['original_price'] ?? null) ? $row['original_price'] : 0,
            'price' => is_numeric($row['price'] ?? null) ? $row['price'] : 0,
            'level' => in_array($row['level'] ?? '', ['beginner', 'intermediate', 'advanced'])
                ? $row['level'] : 'beginner',
            'status' => in_array($row['status'] ?? '', ['draft', 'published', 'archived'])
                ? $row['status'] : 'draft',
            'duration' => is_numeric($row['duration'] ?? null) ? $row['duration'] : 0,
            'published_at' => ! empty($row['published_at'])
                ? Carbon::parse($row['published_at']) : null,
        ]);

        // ✅ Categories sync
        if (! empty($row['categories'])) {
            $categoryIds = array_filter(array_map('trim', explode(',', $row['categories'])));
            $this->courseService->syncCategories($course, $categoryIds);
        }

        // ✅ Sections create
        if (! empty($row['sections'])) {
            $sections = array_filter(array_map('trim', explode(',', $row['sections'])));
            foreach ($sections as $index => $section) {
                $course->sections()->create([
                    'title' => $section,
                    'order' => $index + 1,
                ]);
            }
        }

        return $course;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|numeric|min:0',
            'level' => 'nullable|in:beginner,intermediate,advanced',
            'status' => 'nullable|in:draft,published,archived',
        ];
    }
}
