<?php

namespace Database\Seeders\Permission;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        $permissions = [
            'create-user',
            'update-user',
            'view-user',
            'delete-user',

            'create-product',
            'update-product',
            'view-product',
            'delete-product',

            'create-category',
            'update-category',
            'view-category',
            'delete-category',

            'create-permission',
            'update-permission',
            'view-permission',
            'delete-permission',

            'create-order',
            'update-order',
            'view-order',
            'delete-order',

        ];
        foreach($permissions as $permission)
        {
            Permission::create(['name'=>$permission]);
        }
    }
}
