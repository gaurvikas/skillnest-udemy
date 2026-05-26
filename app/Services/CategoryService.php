<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function create($data)
    {
        try {

            $data['slug'] = Str::slug($data['name']);
            // dd($data);
            Category::create($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($category, $data)
    {

        try {
            $category->update($data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
