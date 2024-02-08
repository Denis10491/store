<?php

namespace Database\Factories;

use App\Models\Nutritional;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->text(30),
            'description' => fake()->text(255),
            'imgPath' => fake()->imageUrl(640, 640, 'eat'),
            'nutritional_id' => Nutritional::factory()->create(),
            'composition' => fake()->text(255),
            'price' => fake()->numberBetween(200, 2000)
        ];
    }
}
