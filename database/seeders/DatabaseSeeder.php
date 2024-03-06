<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
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

        Order::factory(30)
            ->has(
                Product::factory(fake()->numberBetween(1, 10))
                    ->has(Review::factory(fake()->numberBetween(0, 5)))
            )->create();
    }
}
