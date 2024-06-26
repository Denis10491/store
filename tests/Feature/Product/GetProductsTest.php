<?php

namespace Tests\Feature\Product;

use App\Enums\Role;
use App\Models\Product;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Product::factory(2)->create();
    }

    public function test_success(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'img_path',
                'price'
            ]
        ]);
    }

    public function test_admin_success(): void
    {
        $this->login(Role::Admin);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'img_path',
                'price',
                'amount' // Admin can see amount
            ]
        ]);
    }
}
