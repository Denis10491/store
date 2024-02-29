<?php

namespace Tests\Feature\Review;

use App\Models\Product;
use Tests\TestCase;

class CreateReviewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Product::factory(5)->create();
    }

    public function test_error_auth(): void
    {
        $data = [
            'product_id' => Product::all()->random()->id,
            'body' => fake()->text,
            'rating' => fake()->numberBetween(1, 5)
        ];

        $response = $this->post(route('products.reviews.store', 1), $data);

        $response->assertUnauthorized();
    }

    public function test_error_validation(): void
    {
        $this->login();

        $data = [
            'product_id' => Product::all()->random()->id,
            'body' => '',
            'rating' => 0
        ];

        $response = $this->post(route('products.reviews.store', 1), $data);

        $response->assertUnprocessable();
    }

    public function test_success(): void
    {
        $this->login();

        $data = [
            'product_id' => Product::all()->random()->id,
            'body' => fake()->text,
            'rating' => fake()->numberBetween(1, 5)
        ];

        $response = $this->post(route('products.reviews.store', 1), $data);

        $response->assertCreated();
    }
}
