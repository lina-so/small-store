<?php

namespace Database\Seeders\Role;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permission_role')->delete(); // Assuming you have a pivot table for role_permission
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        $roles = ['owner','super-admin','admin','supervisor'];
        $permissions = [
            'create-user',
            'update-user',
            'view-user',
            'delete-user',

            'create-product',
            'update-product',
            'view-product',
            'delete-product',
            'show-product',

            'create-category',
            'update-category',
            'view-category',
            'delete-category',
            'show-category',

            'update-permission',

            'create-order',
            'update-order',
            'view-order',
            'delete-order',
            'show-order',

        ];

        $permissionIds = [];
        foreach ($permissions as $permission) {
            $per = Permission::create(['name' => $permission]);
            $permissionIds[] = $per->id;
        }

        for ($i = 0; $i < 4; $i++) {
            $role = Role::create(['name' => $roles[$i]]);
            for ($j = $i; $j < count($permissions); $j ++) {
                $role->permissions()->attach($permissionIds[$j],['type' => 'allow']);
            }
        }

    }
}
