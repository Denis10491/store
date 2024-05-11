<?php

namespace Database\Seeders;

use App\Enums\Permission as PermissionEnum;
use App\Enums\Role as RoleEnum;
use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            /**
             * Product - Permissions
             */
            'create-product' => [RoleEnum::Admin],
            'read-product-amount' => [RoleEnum::Admin],
            'read-product-statistics' => [RoleEnum::Admin],
            'update-product' => [RoleEnum::Admin],
            'delete-product' => [RoleEnum::Admin],

            /**
             * Order - Permissions
             */
            'create-order' => [RoleEnum::Admin, RoleEnum::User],
            'read-all-orders' => [RoleEnum::Admin],
            'read-personal-orders' => [RoleEnum::User],
            'read-order-statistics' => [RoleEnum::Admin],
            'update-order' => [RoleEnum::Admin],
        ];


        $allRoles = Role::all()->keyBy('name');

        foreach ($permissions as $key => $roles) {
            $permission = Permission::create(['name' => $key]);
            foreach ($roles as $role) {
                $allRoles[$role->value]->permissions()->attach($permission->id);
            }
        }
    }
}
