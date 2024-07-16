<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

    }
}
