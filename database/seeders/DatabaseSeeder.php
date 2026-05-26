<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,  // 1. Pehle categories
            CourseSeeder::class,    // 2. Phir courses
            SectionSeeder::class,   // 3. Phir sections (course pe depend)
            LessonSeeder::class,    // 4. Last mein lessons (section pe depend)
        ]);
    }
}
