<?php

namespace Tests\Feature\Product;

use App\Models\Nutritional;
use App\Models\Product;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    public function test_success(): void
    {
        $data = [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'imgPath' => fake()->imageUrl,
            'proteins' => fake()->numberBetween(100, 500),
            'fats' => fake()->numberBetween(100, 500),
            'carbohydrates' => fake()->numberBetween(100, 500),
            'composition' => fake()->text(50),
            'price' => fake()->numberBetween(100, 5000)
        ];

        $nutritional = Nutritional::query()->create([
            'proteins' => $data['proteins'],
            'fats' => $data['proteins'],
            'carbohydrates' => $data['carbohydrates']
        ]);
        $data['nutritional_id'] = $nutritional->id;
        $product = Product::query()->create($data);

        $response = $this->get(route('products.show', $product->id));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'img_path',
            'nutritional' => [
                'proteins', 'fats', 'carbohydrates'
            ],
            'composition',
            'price'
        ]);
        $response->assertJson([
            'id' => $product->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'img_path' => $data['imgPath'],
            'nutritional' => [
                'proteins' => $data['proteins'],
                'fats' => $data['proteins'],
                'carbohydrates' => $data['carbohydrates']
            ],
            'composition' => $data['composition'],
            'price' => $data['price'],
        ]);
    }
}
