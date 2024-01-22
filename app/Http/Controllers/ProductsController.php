<?php

namespace App\Http\Controllers;

use App\Models\Nutritional;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('nutritional')->latest()->get();
        return response(['status' => true, 'data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'description' => ['required', 'max:1000'],
            'image' => ['required'],
            'proteins' => ['required'],
            'fats' => ['required'],
            'carbohydrates' => ['required'],
            'composition' => ['required', 'max:1000'],
            'price' => ['required']
        ]);

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

        return response(['status' => true, 'product_id' => $product->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(['status' => true, 'data' => Product::with('nutritional')->where('id', $id)->first()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $credentials = $request->validate([
            'name' => ['string'],
            'description' => ['string', 'max:1000'],
            'proteins' => ['string'],
            'fats' => ['string'],
            'carbohydrates' => ['string'],
            'composition' => ['string', 'max:1000'],
            'price' => ['string']
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('', 'public');
            Storage::disk('public')->url($path);
            Product::where('id', $id)->update(["imgPath" => 'storage/'.$path]);
        }

        $product = Product::where('id', $id)->first();
        Product::where('id', $id)->update([
            "name" => $credentials["name"], 
            "description" => $credentials["description"],
            "composition" => $credentials["composition"], 
            "price" => $credentials["price"]
        ]);

        $nutritional = Nutritional::where('id', $product["nutritional_id"])->first();
        Nutritional::where('id', $product["nutritional_id"])->update([
            'proteins' => $credentials["proteins"],
            'fats' => $credentials["fats"],
            'carbohydrates' => $credentials["carbohydrates"],
        ]);

        $product["nutritional"] = $nutritional;
        return response(['status' => true, 'data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response(['status' => Product::where('id', $id)->delete()]);
    }
}
