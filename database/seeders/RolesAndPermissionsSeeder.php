<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Создаём роли
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Создаём разрешения
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);

        // Назначаем разрешения ролям
        $adminRole->givePermissionTo($manageUsers);
    }
}
