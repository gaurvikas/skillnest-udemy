<?php

namespace App\Services;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LessonService
{
    /**
     * Store Lesson
     */
    public function create($request, array $data)
    {
        DB::beginTransaction();

        try {

            $createdLessons = [];

            foreach ($request->lessons as $sectionId => $sectionLessons) {

                foreach ($sectionLessons as $index => $lessonData) {

                    $lesson = Lesson::create([
                        'course_id' => $request->course_id,
                        'section_id' => $lessonData['section_id'],
                        'title' => $lessonData['title'],
                        'slug' => $this->generateUniqueSlug($lessonData['title']),
                        'content' => $lessonData['content'] ?? null,
                        'duration' => $lessonData['duration'] ?? 0,
                        'order' => $lessonData['order'] ?? 0,
                        'is_preview' => $lessonData['is_preview'] ?? 0,
                    ]);

                    if (
                        isset($lessonData['video']) &&
                        $request->file("lessons.$sectionId.$index.video")
                    ) {
                        $lesson
                            ->addMediaFromRequest("lessons.$sectionId.$index.video")
                            ->toMediaCollection('video');
                    }

                    $createdLessons[] = $lesson;
                }
            }

            DB::commit();

            return $createdLessons;
        } catch (Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, Lesson $lesson)
    {
        DB::beginTransaction();

        try {

            $lesson->update([
                'section_id' => $request->section_id,
                'title' => $request->title,
                'slug' => $this->generateUniqueSlug($request->title, $lesson->id),
                'content' => $request->content,
                'duration' => $request->duration ?? 0,
                'order' => $request->order ?? 0,
                'is_preview' => $request->is_preview ?? 0,
            ]);

            if ($request->hasFile('video')) {

                $lesson->clearMediaCollection('video');

                $lesson
                    ->addMediaFromRequest('video')
                    ->toMediaCollection('video');
            }

            DB::commit();

            return $lesson;
        } catch (Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }

    private function generateUniqueSlug(string $title, $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Lesson::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug.'-'.$count++;
        }

        return $slug;
    }
}
