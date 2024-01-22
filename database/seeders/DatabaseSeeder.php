<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsInOrders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Product::factory(250)->create();

        $this->orders();
        $this->roles();
    }

    private function roles()
    {       
        Permission::create(['name' => 'Any']);
        Permission::create(['name' => 'Create store']);
        Permission::create(['name' => 'Get data']);

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo('Create store');
        $roleUser->givePermissionTo('Get data');

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo('Any');

        foreach(User::all() as $user) {
            $user->assignRole('user');
        }
        $admin = User::create([
            "name" => "admin",
            "email" => "admin@admin",
            "password" => "admin"
        ]);
        $admin->assignRole('admin');
    }

    private function orders()
    {
        Order::factory(1200)->create();
        foreach(Order::all() as $order) {
            for($i = 1; $i < 10; $i++) {
                ProductsInOrders::create([
                    'product_id' => Product::all()->random()->id,
                    'order_id' => $order["id"],
                    'count' => rand(1, 7)
                ]);
            }
        }
    }
}