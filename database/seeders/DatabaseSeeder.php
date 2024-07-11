<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $teacherRole = Role::create(['name' => 'teacher']);
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $adminUser->assignRole($adminRole);

        $teacherUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $teacherUser->assignRole($teacherRole);

        $students = Student::factory(30)->create();
        $courses = Course::factory()->createMany(
            [
                ['name' => 'Course 1', 'description' => 'Description 1'],
                ['name' => 'Course 2', 'description' => 'Description 2'],
                ['name' => 'Course 3', 'description' => 'Description 3'],
                ['name' => 'Java', 'description' => 'Java Programming'],
                ['name' => 'Python', 'description' => 'Python Programming'],
                ['name' => 'C++', 'description' => 'C++ Programming'],
                ['name' => 'C#', 'description' => 'C# Programming'],
                ['name' => 'PHP', 'description' => 'PHP Programming'],
                ['name' => 'JavaScript', 'description' => 'JavaScript Programming'],
                ['name' => 'Ruby', 'description' => 'Ruby Programming'],
            ]
        );

        $courses->each(function ($course) use ($students) {
            $randomNumberOfStudents = rand(1, $students->count());

            $course->students()->attach(
                $students->random($randomNumberOfStudents)->pluck('id')->toArray()
            );
            $course->teachers()->attach(
                User::role('teacher')->get()->random()->id
            );
        });
    }
}
