<?php

namespace Tests\Feature\Order;

use App\Enums\OrderStatus;
use App\Http\Resources\Product\OrderProductResource;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()
            ->has(Product::factory(2))
            ->createOne();
    }

    public function test_success_put_all(): void
    {
        $this->login(true);

        $data['address'] = 'example';
        $data['status'] = OrderStatus::Accepted->value;

        $response = $this->put(route('orders.update', ['order' => $this->order->id]), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'address',
            'products',
            'status',
            'created_at'
        ]);
        $response->assertJsonFragment([
            'id' => $this->order->id,
            'address' => $data['address'],
            'products' => OrderProductResource::collection($this->order->products)->additional(['count'])->jsonSerialize(),
            'status' => $data['status'],
            'created_at' => $this->order->created_at
        ]);
    }

    public function test_error_validation_address(): void
    {
        $this->login(true);

        $data['address'] = '';

        $response = $this->put(route('orders.update', ['order' => $this->order->id]), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
        $response->assertJson([
            'message' => 'The address field must be a string.',
            'errors' => [
                'address' => [
                    'The address field must be a string.'
                ]
            ]
        ]);
    }

    public function test_error_validation_status(): void
    {
        $this->login(true);

        $data['status'] = 'new status';

        $response = $this->put(route('orders.update', ['order' => $this->order->id]), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJson([
            'message' => 'No match found.',
        ]);
    }

    public function test_error_auth(): void
    {
        $data['address'] = 'example';
        $data['status'] = OrderStatus::Accepted->value;

        $response = $this->put(route('orders.update', ['order' => $this->order->id]), $data);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'error'
        ]);
        $response->assertJson([
            'error' => 'Unauthenticated.'
        ]);
    }

    public function test_error_permission(): void
    {
        $this->login();

        $data['address'] = 'example';
        $data['status'] = OrderStatus::Accepted->value;

        $response = $this->put(route('orders.update', ['order' => $this->order->id]), $data);

        $response->assertForbidden();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJson([
            'message' => 'Forbidden'
        ]);
    }
}
