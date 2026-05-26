<?php

namespace App\Services;

use App\Models\Enrollment;
use Exception;

class EnrollmentService
{
    /**
     * Create a new enrollment safely.
     */
    public function create($data)
    {
        try {
            Enrollment::create($data);
        } catch (Exception $e) {

            dd('Enrollment creation failed: '.$e->getMessage());
        }
    }

    public function update($enrollment, $data)
    {
        try {
            $enrollment->update($data);
        } catch (Exception $e) {
            dd('Enrollment update failed: '.$e->getMessage());
        }
    }
}
