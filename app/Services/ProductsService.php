<?php

namespace App\Services;

use App\Contracts\ProductsServiceContract;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Nutritional;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsService implements ProductsServiceContract
{
    public function create(array $data, StoreProductRequest $request): ProductsResource
    {
        $createdProduct = DB::transaction(function () use ($data, $request) {
            $path = $request->file('image')->store('', 'public');
            Storage::disk('public')->url($path);

            $nutritional = Nutritional::create([
                "proteins" => $data["proteins"], 
                "fats" => $data["fats"], 
                "carbohydrates" => $data["carbohydrates"]
            ]);

            $product = Product::create([
                "name" => $data["name"], 
                "description" => $data["description"],
                "imgPath" => 'storage/'.$path, 
                "nutritional_id" => $nutritional->id, 
                "composition" => $data["composition"], 
                "price" => $data["price"]
            ]);

            return $product;
        });

        return new ProductsResource($createdProduct);
    }

    public function update(array $data, UpdateProductRequest $request, string $id): ProductsResource
    {
        $updatedProduct = DB::transaction(function () use ($data, $request, $id) : Product { 
            if ($request->file('image')) {
                $path = $request->file('image')->store('', 'public');
                Storage::disk('public')->url($path);
                Product::where('id', $id)->update(["imgPath" => 'storage/'.$path]);
            }

            Product::where('id', $id)->update([
                "name" => $data["name"], 
                "description" => $data["description"],
                "composition" => $data["composition"], 
                "price" => $data["price"]
            ]);
            $product = Product::find($id);

            Nutritional::where('id', $product["nutritional_id"])->update([
                'proteins' => $data["proteins"],
                'fats' => $data["fats"],
                'carbohydrates' => $data["carbohydrates"],
            ]);

            $nutritional = Nutritional::find($product["nutritional_id"]);
            $product["nutritional"] = $nutritional;

            return $product;
        }, 2);
        
        return new ProductsResource($updatedProduct);
    }
}