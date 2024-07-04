<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Role\RoleSeeder;
use Database\Seeders\Order\OrderSeeder;
use Database\Seeders\Products\ProductSeeder;
use Database\Seeders\Categories\CategorySeeder;
use Database\Seeders\Permission\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            RoleSeeder::class,
            // PermissionSeeder::class,


        ]);
    }
}
