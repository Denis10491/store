<?php

namespace Database\Factories;

use App\Models\Nutritional;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nutritional>
 */
class NutritionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proteins' => random_int(10, 1000),
            'fats' => random_int(10, 1000),
            'carbohydrates' => random_int(10, 1000)
        ];
    }
}
