<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AdminUserSeeder::class);

        if (app()->environment(['local', 'testing'])) {
            $this->call(TeacherSeeder::class);
            $this->call(StudentAndCourseSeeder::class);
        }
    }
}
