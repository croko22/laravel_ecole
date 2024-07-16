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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create course']);
        Permission::create(['name' => 'edit course']);
        Permission::create(['name' => 'delete course']);
        Permission::create(['name' => 'view course']);

        Permission::create(['name' => 'create student']);
        Permission::create(['name' => 'edit student']);
        Permission::create(['name' => 'delete student']);
        Permission::create(['name' => 'view student']);

        Permission::create(['name' => 'create teacher']);
        Permission::create(['name' => 'edit teacher']);
        Permission::create(['name' => 'delete teacher']);
        Permission::create(['name' => 'view teacher']);

        Permission::create(['name' => 'take attendance']);

        $teacherRole = Role::create(['name' => 'teacher']);
        $teacherRole->givePermissionTo(['take attendance']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'create course',
            'edit course',
            'delete course',
            'view course',
            'create student',
            'edit student',
            'delete student',
            'view student',
            'create teacher',
            'edit teacher',
            'delete teacher',
            'view teacher',
        ]);

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
