<?php

namespace Tests\Feature\Order;

use App\Enums\Role;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        User::factory(2)->create();
        Order::factory(3)
            ->has(Product::factory(3))
            ->create();
    }

    public function test_error_auth(): void
    {
        $response = $this->get(route('orders.index'));

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'error'
        ]);
        $response->assertJson([
            'error' => 'Unauthenticated.'
        ]);
    }

    public function test_success(): void
    {
        $this->login(Role::User);

        $response = $this->get(route('orders.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'address',
                'products' => [
                    'id',
                    'name',
                    'description',
                    'imgPath',
                    'nutritional' => [
                        'proteins',
                        'fats',
                        'carbohydrates',
                    ],
                    'composition',
                    'price',
                    'count'
                ]
            ]
        ]);
    }
}
