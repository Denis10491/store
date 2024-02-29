<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login();
    }

    public function test_error_validation(): void
    {
        $data = [];

        $response = $this->post(route('products.store'), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'description',
                'image',
                'proteins',
                'fats',
                'carbohydrates',
                'composition',
                'price'
            ]
        ]);
    }

    public function test_success(): void
    {
        $data = [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'image' => UploadedFile::fake()->image('example.png'),
            'proteins' => fake()->numberBetween(100, 500),
            'fats' => fake()->numberBetween(100, 500),
            'carbohydrates' => fake()->numberBetween(100, 500),
            'composition' => fake()->text(50),
            'price' => fake()->numberBetween(100, 5000)
        ];

        $response = $this->post(route('products.store'), $data);

        $response->assertCreated();
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
            'name' => $data['name'],
            'description' => $data['description'],
            'nutritional' => [
                'proteins' => $data['proteins'],
                'fats' => $data['fats'],
                'carbohydrates' => $data['carbohydrates']
            ],
            'composition' => $data['composition'],
            'price' => $data['price']
        ]);
    }
}
