<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Nutritional;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $page)
    {
        $data = Product::with('nutritional')->orderBy('id', 'DESC')->paginate(30, '*', 'page', $page);
        return response(['status' => true, 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $credentials = $request->validated();

        $product = DB::transaction(function () use ($credentials, $request) {
            $path = $request->file('image')->store('', 'public');
            Storage::disk('public')->url($path);

            $nutritional = Nutritional::create([
                "proteins" => $credentials["proteins"], 
                "fats" => $credentials["fats"], 
                "carbohydrates" => $credentials["carbohydrates"]
            ]);

            $product = Product::create([
                "name" => $credentials["name"], 
                "description" => $credentials["description"],
                "imgPath" => 'storage/'.$path, 
                "nutritional_id" => $nutritional->id, 
                "composition" => $credentials["composition"], 
                "price" => $credentials["price"]
            ]);

            return $product;
        });

        return response(['status' => true, 'data' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('nutritional')->find($id);
        return response([
            'status' => $product ? true : false, 
            'data' => new ProductsResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $credentials = $request->validated();

        $product = DB::transaction(function () use ($credentials, $request, $id) : Product { 
            if ($request->file('image')) {
                $path = $request->file('image')->store('', 'public');
                Storage::disk('public')->url($path);
                Product::where('id', $id)->update(["imgPath" => 'storage/'.$path]);
            }

            Product::where('id', $id)->update([
                "name" => $credentials["name"], 
                "description" => $credentials["description"],
                "composition" => $credentials["composition"], 
                "price" => $credentials["price"]
            ]);
            $product = Product::find($id);

            Nutritional::where('id', $product["nutritional_id"])->update([
                'proteins' => $credentials["proteins"],
                'fats' => $credentials["fats"],
                'carbohydrates' => $credentials["carbohydrates"],
            ]);

            $nutritional = Nutritional::find($product["nutritional_id"]);
            $product["nutritional"] = $nutritional;

            return $product;
        }, 2);

        return response([
            'status' => true, 
            'data' => new ProductsResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response(['status' => Product::destroy($id)]);
    }
}
