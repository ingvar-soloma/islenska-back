<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    final public function run(): void
    {
        $permissions = [
            'get new translation',
            'add translation',

            'view users',
            'edit users',
            'delete users',

            'view users statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'admin' => ['add translation', 'view users', 'edit users', 'delete users', 'view users statistics', 'get new translation'],
            'translator' => ['add translation', 'get new translation'],
            'approved user' => ['get new translation'],

        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
