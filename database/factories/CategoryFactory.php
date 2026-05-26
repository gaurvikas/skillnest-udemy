<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;

        $categories = [
            'Development',
            'Business',
            'Finance & Accounting',
            'IT & Software',
            'Office Productivity',
            'Personal Development',
            'Design',
            'Marketing',
            'Lifestyle',
            'Photography & Video',
            'Health & Fitness',
            'Music',
            'Teaching & Academics',
            'Data Science',
            'Artificial Intelligence',
            'Cyber Security',
            'Cloud Computing',
            'Mobile Development',
            'Web Development',
            'Game Development',
        ];

        $name = $categories[$index % count($categories)];
        $index++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $name.' related online courses',
            'status' => 1,
            'icon' => 'default-icon',
            'parent_id' => null,
        ];
    }
}
