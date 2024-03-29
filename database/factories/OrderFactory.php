<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'address' => fake()->address(),
            'created_at' => $this->faker->dateTimeBetween('-60 days'),
            'updated_at' => $this->faker->dateTimeBetween('-60 days')
        ];
    }
}
