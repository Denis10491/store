<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'img_path' => $this->imgPath,
            'nutritional' => new NutritionalResource($this->nutritional),
            'composition' => $this->composition,
            'price' => $this->price,
            'amount' => $this->when(Gate::check('read-product-amount'), $this->amount),
            'reviews' => ReviewResource::collection($this->reviews)
        ];
    }
}
