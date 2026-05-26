<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sections')->delete();

        $courses = DB::table('courses')->pluck('id');

        if ($courses->isEmpty()) {
            $this->command->warn('⚠️  Pehle CourseSeeder run karo!');
            return;
        }

        // Section sets — har course ko ek matching set milega
        $sectionSets = [
            'web' => [
                ['title' => 'Getting Started'],
                ['title' => 'Core Fundamentals'],
                ['title' => 'Intermediate Concepts'],
                ['title' => 'Working with APIs'],
                ['title' => 'Building a Real Project'],
                ['title' => 'Advanced Topics'],
                ['title' => 'Deployment & Conclusion'],
            ],
            'database' => [
                ['title' => 'Introduction to Databases'],
                ['title' => 'SQL Basics & Queries'],
                ['title' => 'Joins & Relationships'],
                ['title' => 'Advanced Database Concepts'],
                ['title' => 'Hands-on Project'],
                ['title' => 'Conclusion & Next Steps'],
            ],
            'design' => [
                ['title' => 'Introduction to Design'],
                ['title' => 'Design Principles & Theory'],
                ['title' => 'UI Design with Figma'],
                ['title' => 'UX Research & Prototyping'],
                ['title' => 'Real-world Design Project'],
                ['title' => 'Conclusion & Career Tips'],
            ],
            'data_science' => [
                ['title' => 'Getting Started with Python'],
                ['title' => 'Data Manipulation & Analysis'],
                ['title' => 'Data Visualisation'],
                ['title' => 'Machine Learning Basics'],
                ['title' => 'Advanced ML Models'],
                ['title' => 'Real-world Project'],
                ['title' => 'Conclusion & Wrap-up'],
            ],
            'devops' => [
                ['title' => 'Introduction & Overview'],
                ['title' => 'Core Fundamentals'],
                ['title' => 'Intermediate Concepts'],
                ['title' => 'Hands-on Project Build'],
                ['title' => 'Advanced Configuration'],
                ['title' => 'Deployment & Conclusion'],
            ],
        ];

        // Cycle through section sets for variety
        $setKeys = array_keys($sectionSets);
        $rows    = [];

        foreach ($courses as $index => $courseId) {
            $setKey   = $setKeys[$index % count($setKeys)];
            $sections = $sectionSets[$setKey];

            foreach ($sections as $section) {
                $rows[] = [
                    'course_id'  => $courseId,
                    'title'      => $section['title'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('sections')->insert($rows);

        $this->command->info('✅ ' . count($rows) . ' sections seeded successfully.');
    }
}
