<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        Product::factory(2)->create();
    }

    public function test_error_validation(): void
    {
        $this->login();

        $data = [
            'address' => '',
            'products' => []
        ];

        $response = $this->post(route('orders.store'), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'products',
                'address'
            ]
        ]);
    }

    public function test_error_auth(): void
    {
        $data = [
            'address' => fake()->address(),
            'products' => [
                ['id' => 1, 'count' => random_int(1, 5)],
                ['id' => 2, 'count' => random_int(1, 5)],
            ]
        ];

        $response = $this->post(route('orders.store'), $data);

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
        $this->login();

        $data = [
            'address' => fake()->address(),
            'products' => [
                ['id' => 1, 'count' => random_int(1, 5)],
                ['id' => 2, 'count' => random_int(1, 5)],
            ]
        ];

        $response = $this->post(route('orders.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id', 'address',
            'products' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'count'
                ]
            ]
        ]);
        $response->assertJson([
            'address' => $data['address'],
            'products' => [
                [
                    'id' => $data['products'][0]['id'],
                    'count' => $data['products'][0]['count']
                ],
                [
                    'id' => $data['products'][1]['id'],
                    'count' => $data['products'][1]['count']
                ]
            ]
        ]);
    }
}
