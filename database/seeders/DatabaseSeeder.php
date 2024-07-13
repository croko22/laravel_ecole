<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherRole->givePermissionTo('take attendance');

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
        ]);
        $adminUser->assignRole($adminRole);

        $teachers = User::factory(10)->create();
        $teachers->each(function ($teacher) use ($teacherRole) {
            $teacher->assignRole($teacherRole);
        });

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
