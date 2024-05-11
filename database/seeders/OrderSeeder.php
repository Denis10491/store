<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory(30)
            ->has(
                Product::factory(fake()->numberBetween(1, 10))
                    ->has(Review::factory(fake()->numberBetween(0, 5)))
            )->create();
    }
}
