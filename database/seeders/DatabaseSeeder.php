<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'email' => 'admin@admin',
            'password' => 'admin',
            'role' => UserRole::Admin
        ]);
        Product::factory(250)->create();

        Order::factory(200)
            ->has(Product::factory(10))
            ->create();
    }
}
