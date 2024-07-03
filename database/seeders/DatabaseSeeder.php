<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $courses = Course::factory()->createMany(
            [
                ['name' => 'Course 1', 'description' => 'Description 1'],
                ['name' => 'Course 2', 'description' => 'Description 2'],
                ['name' => 'Course 3', 'description' => 'Description 3'],
            ]
        );
        $students = Student::factory(10)->create();

        // Iterate over each course and attach users
        $courses->each(function ($course) use ($students) {
            $course->students()->attach(
                $students->random(5)->pluck('id')->toArray()
            );
        });
    }
}
