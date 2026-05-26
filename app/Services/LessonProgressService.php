<?php

namespace App\Services;

use App\Models\LessonProgress;
use Exception;

class LessonProgressService
{
    /**
     * Create a new class instance.
     */
    public function create($data)
    {
        try {
            LessonProgress::create($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($LessonProgress, $data)
    {
        try {
            $LessonProgress->update($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
