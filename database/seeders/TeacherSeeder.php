<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = User::factory(10)->create();
        $teachers->each(fn($teacher) => $teacher->assignRole('teacher'));
    }
}
