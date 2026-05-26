<?php

namespace App\Services;

use App\Models\Section;
use Exception;

class SectionService
{
    /**
     * Create a new class instance.
     */
    public function create(array $data)
    {
        try {
            return Section::create($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
