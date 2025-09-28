<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;

class StudentAndCourseSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::factory(30)->create();
        $courses = Course::factory()->createMany([
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
        ]);

        $courses->each(function ($course) use ($students) {
            $course->students()->attach(
                $students->random(rand(1, $students->count()))->pluck('id')->toArray()
            );
            $course->teachers()->attach(
                User::role('teacher')->inRandomOrder()->first()->id
            );
        });
    }
}
