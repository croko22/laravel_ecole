<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
        ]);
        $adminUser->assignRole('admin');

        $teachers = User::factory(10)->create();
        $teachers->each(function ($teacher) {
            $teacher->assignRole('teacher');
        });

        $students = Student::factory(30)->create();
        $courses = Course::factory()->createMany(
            [
                ['name' => 'Java', 'description' => 'Java Programming'],
                ['name' => 'Python', 'description' => 'Python Programming'],
                ['name' => 'C++', 'description' => 'C++ Programming'],
                ['name' => 'C#', 'description' => 'C# Programming'],
                ['name' => 'PHP', 'description' => 'PHP Programming'],
                ['name' => 'JavaScript', 'description' => 'JavaScript Programming'],
                ['name' => 'Ruby', 'description' => 'Ruby Programming'],
                ['name' => 'Swift', 'description' => 'Swift Programming'],
                ['name' => 'Kotlin', 'description' => 'Kotlin Programming'],
                ['name' => 'Go', 'description' => 'Go Programming'],
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
