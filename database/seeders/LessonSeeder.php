<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lessons')->delete();

        // Sections ka data fetch karo
        $sections = DB::table('sections')->get();

        if ($sections->isEmpty()) {
            $this->command->warn('⚠️  Pehle SectionSeeder run karo!');
            return;
        }

        $rows = [];

        // Har section ke liye relevant lessons
        $lessonTemplates = [

            // ── Introduction / Getting Started sections ──────────────────────
            'introduction' => [
                ['title' => 'Course Overview & What You Will Learn',       'duration' => 5, 'is_preview' => 1,  'content' => 'Welcome to the course! In this lecture we cover what you will learn, prerequisites and how to get the most out of this course.'],
                ['title' => 'How to Use This Course Effectively',           'duration' => 4, 'is_preview' => 1,  'content' => 'Tips on how to watch lectures, use the Q&A section, download resources and set up your learning schedule.'],
                ['title' => 'Setting Up Your Development Environment',      'duration' => 12, 'is_preview' => 0, 'content' => 'Step-by-step guide to installing all required tools and software. We configure VS Code, extensions and terminal.'],
                ['title' => 'Installing Required Tools & Software',         'duration' => 8, 'is_preview' => 0, 'content' => 'Install Node.js, Git, and other dependencies. Verify installations and fix common errors.'],
                ['title' => 'Your First Hello World Program',               'duration' => 6, 'is_preview' => 1,  'content' => 'Write and run your very first program. Understand the basic structure and syntax.'],
            ],

            // ── Core Fundamentals ─────────────────────────────────────────────
            'fundamentals' => [
                ['title' => 'Variables, Data Types & Operators',            'duration' => 18, 'is_preview' => 0, 'content' => 'Deep dive into variables, primitive data types, type coercion and all operators with practical examples.'],
                ['title' => 'Control Flow – If/Else & Switch Statements',   'duration' => 14, 'is_preview' => 0, 'content' => 'Conditional logic, nested conditions and switch-case statements explained with real-world scenarios.'],
                ['title' => 'Loops – For, While & Do-While',                'duration' => 16, 'is_preview' => 0, 'content' => 'Iteration patterns, break/continue, nested loops and when to use each type of loop.'],
                ['title' => 'Functions – Declaration, Expression & Arrow',  'duration' => 22, 'is_preview' => 0, 'content' => 'Function types, parameters, default values, rest parameters, return values and scope.'],
                ['title' => 'Arrays & Array Methods Deep Dive',             'duration' => 25, 'is_preview' => 0, 'content' => 'map, filter, reduce, find, some, every, flat and more. Practical exercises included.'],
                ['title' => 'Objects & Object-Oriented Programming Basics', 'duration' => 20, 'is_preview' => 0, 'content' => 'Creating objects, dot notation, destructuring, spread operator and object methods.'],
            ],

            // ── Intermediate Concepts ─────────────────────────────────────────
            'intermediate' => [
                ['title' => 'Classes & Inheritance',                        'duration' => 19, 'is_preview' => 0, 'content' => 'ES6 classes, constructors, inheritance, super keyword, static methods and encapsulation.'],
                ['title' => 'Asynchronous Programming – Callbacks & Promises', 'duration' => 23, 'is_preview' => 0, 'content' => 'The event loop, callback hell, Promises, chaining and error handling with .catch().'],
                ['title' => 'Async/Await & Error Handling',                 'duration' => 18, 'is_preview' => 0, 'content' => 'Writing clean async code with async/await, try/catch blocks and handling multiple async operations.'],
                ['title' => 'Modules – Import & Export',                    'duration' => 12, 'is_preview' => 0, 'content' => 'CommonJS vs ES Modules, named exports, default exports and organising your codebase.'],
                ['title' => 'Working with APIs & Fetch',                    'duration' => 21, 'is_preview' => 0, 'content' => 'Making HTTP requests with Fetch API, handling JSON, GET/POST requests and REST principles.'],
            ],

            // ── Project / Hands-on sections ───────────────────────────────────
            'project' => [
                ['title' => 'Project Introduction & Planning',              'duration' => 7, 'is_preview' => 1,  'content' => 'Overview of what we will build, the tech stack, folder structure and project requirements.'],
                ['title' => 'Setting Up the Project Structure',             'duration' => 10, 'is_preview' => 0, 'content' => 'Initialise the project, install dependencies and configure environment variables.'],
                ['title' => 'Building the Database Schema',                 'duration' => 15, 'is_preview' => 0, 'content' => 'Design and create tables/models, relationships and migrations.'],
                ['title' => 'Implementing Authentication',                  'duration' => 24, 'is_preview' => 0, 'content' => 'JWT authentication, login, register, middleware for protected routes.'],
                ['title' => 'Building CRUD Operations',                     'duration' => 28, 'is_preview' => 0, 'content' => 'Create, Read, Update, Delete operations with proper validation and error handling.'],
                ['title' => 'Connecting Frontend to Backend',               'duration' => 20, 'is_preview' => 0, 'content' => 'API integration, state management, loading states and error handling on the client side.'],
                ['title' => 'Deployment – Taking the App Live',             'duration' => 18, 'is_preview' => 0, 'content' => 'Deploy to a cloud platform, set up environment variables, configure domains and SSL.'],
            ],

            // ── Advanced Topics ───────────────────────────────────────────────
            'advanced' => [
                ['title' => 'Performance Optimisation Techniques',          'duration' => 22, 'is_preview' => 0, 'content' => 'Lazy loading, code splitting, memoization, caching strategies and profiling tools.'],
                ['title' => 'Security Best Practices',                      'duration' => 19, 'is_preview' => 0, 'content' => 'OWASP Top 10, input validation, SQL injection prevention, XSS, CSRF and rate limiting.'],
                ['title' => 'Testing – Unit, Integration & E2E',            'duration' => 26, 'is_preview' => 0, 'content' => 'Write tests with Jest/PHPUnit. TDD workflow, mocking, coverage reports and CI integration.'],
                ['title' => 'Design Patterns in Practice',                  'duration' => 24, 'is_preview' => 0, 'content' => 'Repository pattern, Factory, Observer, Strategy and Singleton patterns with real examples.'],
                ['title' => 'Refactoring & Clean Code Principles',          'duration' => 17, 'is_preview' => 0, 'content' => 'SOLID principles, DRY, KISS, code smells and hands-on refactoring exercises.'],
            ],

            // ── Database & Backend specific ───────────────────────────────────
            'database' => [
                ['title' => 'Introduction to Databases & SQL Basics',       'duration' => 14, 'is_preview' => 1,  'content' => 'What is a database, relational vs NoSQL, SQL syntax basics and connecting to MySQL.'],
                ['title' => 'SELECT Queries – Filtering, Sorting & Limiting', 'duration' => 16, 'is_preview' => 0, 'content' => 'WHERE, ORDER BY, LIMIT, OFFSET, LIKE, IN, BETWEEN and DISTINCT clauses.'],
                ['title' => 'Joins – INNER, LEFT, RIGHT & FULL',            'duration' => 20, 'is_preview' => 0, 'content' => 'Combining data from multiple tables with all join types and practical exercises.'],
                ['title' => 'Aggregations – GROUP BY, HAVING & Functions',  'duration' => 15, 'is_preview' => 0, 'content' => 'COUNT, SUM, AVG, MIN, MAX, GROUP BY and HAVING for data summarisation.'],
                ['title' => 'Database Indexing & Query Optimisation',       'duration' => 18, 'is_preview' => 0, 'content' => 'How indexes work, creating indexes, EXPLAIN plan analysis and query tuning.'],
                ['title' => 'Relationships & Foreign Keys',                  'duration' => 13, 'is_preview' => 0, 'content' => 'One-to-one, one-to-many, many-to-many relationships and referential integrity.'],
            ],

            // ── UI/Design specific ────────────────────────────────────────────
            'design' => [
                ['title' => 'Design Principles – Color, Typography & Space', 'duration' => 16, 'is_preview' => 1,  'content' => 'Foundational design theory: colour psychology, type hierarchy, whitespace and visual balance.'],
                ['title' => 'Creating Wireframes from Scratch',              'duration' => 20, 'is_preview' => 0, 'content' => 'Low-fidelity wireframing process, user flow mapping and communicating ideas quickly.'],
                ['title' => 'Building a Design System in Figma',            'duration' => 28, 'is_preview' => 0, 'content' => 'Components, auto-layout, variants, tokens and publishing a shared design library.'],
                ['title' => 'Prototyping & Interactive Flows',              'duration' => 15, 'is_preview' => 0, 'content' => 'Link frames, add interactions, smart animate and share clickable prototypes with stakeholders.'],
                ['title' => 'User Research & Usability Testing',            'duration' => 18, 'is_preview' => 0, 'content' => 'Conducting user interviews, usability tests, affinity mapping and turning insights into design decisions.'],
            ],

            // ── Wrap-up / Conclusion ──────────────────────────────────────────
            'conclusion' => [
                ['title' => 'Course Recap & Key Takeaways',                 'duration' => 6, 'is_preview' => 0, 'content' => 'Summary of everything covered in the course and how all the pieces fit together.'],
                ['title' => 'What to Learn Next – Roadmap',                 'duration' => 5, 'is_preview' => 0, 'content' => 'Recommended next steps, resources, books and courses to continue your learning journey.'],
                ['title' => 'Bonus: Tips for Getting Your First Job',       'duration' => 9, 'is_preview' => 0, 'content' => 'Resume tips, portfolio building, GitHub profile, interview prep and negotiating your salary.'],
            ],
        ];

        // ─── Assign lessons to each section ──────────────────────────────────
        foreach ($sections as $section) {
            $titleLower = strtolower($section->title);

            // Pick appropriate template based on section title keywords
            if (str_contains($titleLower, 'intro') || str_contains($titleLower, 'getting started') || str_contains($titleLower, 'overview')) {
                $template = $lessonTemplates['introduction'];
            } elseif (str_contains($titleLower, 'advanced') || str_contains($titleLower, 'expert')) {
                $template = $lessonTemplates['advanced'];
            } elseif (str_contains($titleLower, 'project') || str_contains($titleLower, 'build') || str_contains($titleLower, 'hands')) {
                $template = $lessonTemplates['project'];
            } elseif (str_contains($titleLower, 'database') || str_contains($titleLower, 'sql') || str_contains($titleLower, 'data')) {
                $template = $lessonTemplates['database'];
            } elseif (str_contains($titleLower, 'design') || str_contains($titleLower, 'ui') || str_contains($titleLower, 'figma')) {
                $template = $lessonTemplates['design'];
            } elseif (str_contains($titleLower, 'conclusion') || str_contains($titleLower, 'wrap') || str_contains($titleLower, 'final')) {
                $template = $lessonTemplates['conclusion'];
            } elseif (str_contains($titleLower, 'intermediate') || str_contains($titleLower, 'async') || str_contains($titleLower, 'api')) {
                $template = $lessonTemplates['intermediate'];
            } else {
                $template = $lessonTemplates['fundamentals'];
            }

            foreach ($template as $order => $lesson) {
                $rows[] = [
                    'section_id' => $section->id,
                    'title'      => $lesson['title'],
                    'slug'       => Str::slug($lesson['title']) . '-' . $section->id . '-' . ($order + 1),
                    'content'    => $lesson['content'],
                    'duration'   => $lesson['duration'],
                    'order'      => $order + 1,
                    'is_preview' => $lesson['is_preview'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Batch insert for performance
        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('lessons')->insert($chunk);
        }

        $this->command->info('✅ ' . count($rows) . ' lessons seeded successfully.');
    }
}
