<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\OrderProductResource;
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
        return [
            'id' => $this->id,
            'address' => $this->address,
            'products' => OrderProductResource::collection($this->products)->additional(['count']),
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
