<?php

namespace Tests\Feature\Review;

use App\Models\Product;
use App\Models\Review;
use Tests\TestCase;

class UpdateReviewTest extends TestCase
{
    protected Product $product;

    protected Review $review;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login();

        $this->product = Product::factory()->createOne();

        $this->review = $this->user->reviews()->create([
            'product_id' => $this->product->id,
            'body' => fake()->text(50),
            'rating' => fake()->numberBetween(1, 5)
        ]);
    }

    public function test_success_put(): void
    {
        $data = [
            'body' => fake()->text(100),
            'rating' => fake()->numberBetween(1, 5)
        ];

        $response = $this->put(route('reviews.update', $this->review->id), $data);

        $response->assertOk();
    }

    public function test_success_patch_body(): void
    {
        $data = [
            'body' => fake()->text(100)
        ];

        $response = $this->patch(route('reviews.update', $this->review->id), $data);

        $response->assertOk();
    }

    public function test_success_patch_rating(): void
    {
        $data = [
            'rating' => fake()->numberBetween(1, 5)
        ];

        $response = $this->patch(route('reviews.update', $this->review->id), $data);

        $response->assertOk();
    }
}
