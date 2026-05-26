<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions list
        $permissions = [

            // Users
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Users
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Courses
            'course.view',
            'course.create',
            'course.edit',
            'course.delete',

            // Courses review
            'course-review.view',
            'course-review.create',
            'course-review.edit',
            'course-review.delete',

            // Certificates
            'certificate.view',
            'certificate.create',
            'certificate.edit',
            'certificate.delete',

            // Categories
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            // Enrollments
            'enrollment.view',
            'enrollment.create',
            'enrollment.edit',
            'enrollment.delete',

            // Lesson
            'lesson.view',
            'lesson.create',
            'lesson.edit',
            'lesson.delete',

            // Lesson Progress
            'lesson-progress.view',
            'lesson-progress.create',
            'lesson-progress.edit',
            'lesson-progress.delete',

        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        // Create roles
        $admin = Role::create(['name' => 'Admin']);

        $instructor = Role::create(['name' => 'Instructor']);

        $student = Role::create(['name' => 'Student']);

        // Assign permissions

        // Admin gets all permissions
        $admin->givePermissionTo(Permission::all());

        // Instructor permissions
        $instructor->givePermissionTo([
            'course.view',
            'course.create',
            'course.edit',

            'certificate.view',

            'category.view',

            'enrollment.view',
        ]);

        // Student permissions
        $student->givePermissionTo([
            'course.view',

            'certificate.view',

            'enrollment.view',
            'enrollment.create',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'dinesh@admin.com'],
            [
                'name' => 'Dinesh Kumar',
                'password' => Hash::make('dinesh123'),
            ]
        );

        // Assign Admin Role
        $adminUser->assignRole($admin);
    }
}
