<?php

namespace App\Http\Resources;

use App\Models\OrderProduct;
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
        $products = OrderProduct::with('product:id,name,price')
            ->where('order_products.order_id', $this->id)
            ->select('count', 'product_id')
            ->get();
        foreach($products as $key => $product) {
            $products[$key] = [
                'id' => $product['product']['id'],
                'name' => $product['product']['name'],
                'price' => $product['product']['price'],
                'count' => $product['count']
            ];
        }
        return [
            'id' => $this->id,
            'address' => $this->address,
            'products' => $products,
            'created_at' => $this->created_at
        ];
    }
}
