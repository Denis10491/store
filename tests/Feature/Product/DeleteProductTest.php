<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login();

        $this->product = Product::factory()->createOne();
    }

    public function test_error_notfound(): void
    {

        $response = $this->delete(route('products.destroy', 0));

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
        $response = $this->delete(route('products.destroy', $this->product->id));

        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJson([
            'message' => 'Success'
        ]);
    }
}
