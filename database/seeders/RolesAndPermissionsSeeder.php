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
        $permissions = [
            'view tag',
            'create tag',
            'update tag',
            'delete tag',
            'view category',
            'create category',
            'update category',
            'delete category',
            'view post',
            'create post',
            'update post',
            'delete post',
            'view page',
            'create page',
            'update page',
            'delete page',
            'view users',
            'create users',
            'update users',
            'delete users',
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Назначаем разрешения ролям
        $adminRole->syncPermissions($permissions);
    }
}
