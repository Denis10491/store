<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\ProductsCollection;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = OrderProduct::with('products:id,name,price')
            ->with('orders')
            ->where('order_products.order_id', $this->id)
            ->select('product_id', 'count')
            ->get();
        // foreach($products as $key => $product) {
        //     $products[$key] = [
        //         'id' => $product['product']['id'],
        //         'name' => $product['product']['name'],
        //         'price' => $product['product']['price'],
        //         'count' => $product['count']
        //     ];
        // }
        return [
            'id' => $this->id,
            'address' => $this->address,
            'products' => new ProductsCollection($products),
            'created_at' => $this->created_at
        ];
    }
}
