<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin' => [
                'manage users',
                'manage products',
                'manage categories',
                'manage orders',
                'manage coupons',
                'view reports',
            ],
            'Customer' => [],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permissionName);
            }
        }
    }
}
