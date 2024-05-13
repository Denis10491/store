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

    public function test_success_amount_empty(): void
    {
        $data = [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'imgPath' => fake()->imageUrl,
            'proteins' => fake()->numberBetween(100, 500),
            'fats' => fake()->numberBetween(100, 500),
            'carbohydrates' => fake()->numberBetween(100, 500),
            'composition' => fake()->text(50),
            'price' => fake()->numberBetween(100, 5000),
            'amount' => 0
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
        $response->assertJsonMissing(['amount' => 0]);
    }

    public function test_success_admin(): void
    {
        $this->login(true);

        $data = [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'imgPath' => fake()->imageUrl,
            'proteins' => fake()->numberBetween(100, 500),
            'fats' => fake()->numberBetween(100, 500),
            'carbohydrates' => fake()->numberBetween(100, 500),
            'composition' => fake()->text(50),
            'price' => fake()->numberBetween(100, 5000),
            'amount' => fake()->numberBetween(0, 50)
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
            'price',
            'amount'
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
            'amount' => $data['amount']
        ]);
    }
}
