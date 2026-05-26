<?php

namespace App\Services;

use App\Models\CourseReview;
use Exception;

class CourseReviewService
{
    /**
     * Create a new class instance.
     */
    public function create($data)
    {
        try {
            CourseReview::create($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($CourseReview, $data)
    {
        try {
            $CourseReview->update($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
