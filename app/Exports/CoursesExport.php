<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CoursesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Course::with('instructor')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Instructor',
            'Title',
            'Slug',
            'Description',
            'Original Price ($)',
            'Price ($)',
            'Level',
            'Status',
            'Duration (min)',
            'Published At',
        ];
    }

    public function map($course): array
    {
        return [
            $course->id,
            $course->instructor->name ?? 'N/A',
            $course->title,
            $course->slug,
            $course->description,
            number_format($course->original_price, 2),
            number_format($course->price, 2),
            ucfirst($course->level),
            ucfirst($course->status),
            $course->duration,
            $course->published_at?->format('d M Y') ?? 'Not Published',
        ];
    }
}
