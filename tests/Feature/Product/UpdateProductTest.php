<?php

namespace Tests\Feature\Product;

use App\Enums\Role;
use App\Models\Product;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login(Role::Admin);

        $this->product = Product::factory()->createOne();
    }

    public function test_success_put(): void
    {
        $data = [
            'name' => fake()->sentence
        ];

        $response = $this->put(route('products.update', $this->product->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'img_path',
            'nutritional' => [
                'proteins',
                'fats',
                'carbohydrates'
            ],
            'composition',
            'price',
            'amount',
            'reviews'
        ]);
        $response->assertJson([
            'name' => $data['name'],
            'description' => '',
            'nutritional' => [
                'proteins' => 0,
                'fats' => 0,
                'carbohydrates' => 0
            ],
            'composition' => '',
            'amount' => 0,
            'price' => 0
        ]);
    }

    public function test_success_patch(): void
    {
        $data = [
            'name' => fake()->sentence,
            'fats' => fake()->numberBetween(5, 50),
            'price' => fake()->numberBetween(100, 5000),
            'amount' => fake()->numberBetween(0, 10)
        ];

        $response = $this->patch(route('products.update', $this->product->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'img_path',
            'nutritional' => [
                'proteins',
                'fats',
                'carbohydrates'
            ],
            'composition',
            'price',
            'amount'
        ]);
        $response->assertJson([
            'name' => $data['name'],
            'description' => $this->product->description,
            'nutritional' => [
                'proteins' => $this->product->nutritional->proteins,
                'fats' => $data['fats'],
                'carbohydrates' => $this->product->nutritional->carbohydrates,
            ],
            'composition' => $this->product->composition,
            'price' => $data['price'],
            'amount' => $data['amount']
        ]);
    }
}
