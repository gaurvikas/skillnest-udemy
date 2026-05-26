<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Complete Laravel Bootcamp',
            'Mastering React JS',
            'Python for Beginners',
            'Full Stack MERN Course',
            'AWS Cloud Practitioner',
            'Ethical Hacking Masterclass',
            'Machine Learning with Python',
            'Flutter App Development',
            'UI/UX Design Fundamentals',
            'Digital Marketing Mastery',
            'Advanced Java Programming',
            'Docker & Kubernetes Guide',
            'Node.js API Development',
            'Power BI Complete Course',
            'Financial Accounting Basics',
            'Photography from Beginner to Pro',
            'Excel for Professionals',
            'AI & Deep Learning Course',
            'Unity Game Development',
            'SEO Complete Course',
        ];

        $title = $this->faker->randomElement($titles).' '.rand(2024, 2026);

        return [
            'instructor_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(4),
            'original_price' => $this->faker->numberBetween(499, 4999),
            'price' => $this->faker->numberBetween(499, 4999),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'status' => 'published',
            'duration' => $this->faker->numberBetween(5, 40),
            'published_at' => now(),
        ];
    }
}
