<?php

namespace App\Http\Resources;

use App\Models\ProductsInOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = ProductsInOrders::join('products', 'products_in_orders.product_id', '=', 'products.id')
            ->where('products_in_orders.order_id', $this->id)
            ->select('products.name', 'products.price', 'products_in_orders.count', 'products_in_orders.product_id')
            ->get();
        return [
            'id' => $this->id,
            'address' => $this->address,
            'products' => $products,
            'created_at' => $this->created_at
        ];
    }
}
