<?php

namespace App\Http\Resources\Product;

use App\Models\Nutritional;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'imgPath' => $this->imgPath,
            'nutritional' => new NutritionalResource(Nutritional::find($this->nutritional_id)),
            'composition' => $this->composition,
            'price' => $this->price
        ];
    }
}
