<?php

namespace Tests\Feature\Review;

use App\Models\Product;
use App\Models\Review;
use Tests\TestCase;

class DeleteReviewTest extends TestCase
{
    protected Review $review;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login();

        $product = Product::factory()->createOne();
        $this->review = $this->user->reviews()->create([
            'body' => 'example',
            'rating' => 5,
            'product_id' => $product->id
        ]);
    }

    public function test_error_notfound(): void
    {
        $response = $this->delete(route('reviews.destroy', 0));

        $response->assertNotFound();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJson([
            'message' => 'Not found.'
        ]);
    }

    public function test_success(): void
    {

        $response = $this->delete(route('reviews.destroy', $this->review->id));

        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJson([
            'message' => 'Success'
        ]);
    }
}
