<?php

namespace App\Services\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Nutritional;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductServiceContract
{
    public function create(array $data, StoreProductRequest $request): ProductsResource
    {
        $createdProduct = DB::transaction(function () use ($data, $request) {
            $path = $request->file('image')->store('', 'public');
            Storage::disk('public')->url($path);
            $nutritional = Nutritional::create([
                'proteins' => $data['proteins'],
                'fats' => $data['fats'],
                'carbohydrates' => $data['carbohydrates']
            ]);
            return Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'imgPath' => 'storage/'.$path,
                'nutritional_id' => $nutritional->id,
                'composition' => $data['composition'],
                'price' => $data['price']
            ]);
        });
        return new ProductsResource($createdProduct);
    }

    public function update(array $data, UpdateProductRequest $request, string $id): ProductsResource
    {
        $updatedProduct = DB::transaction(function () use ($data, $request, $id): Product {
            if ($request->file('image')) {
                $path = $request->file('image')->store('', 'public');
                Storage::disk('public')->url($path);
                Product::where('id', $id)->update(['imgPath' => 'storage/'.$path]);
            }
            Product::where('id', $id)->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'composition' => $data['composition'],
                'price' => $data['price']
            ]);
            $product = Product::find($id);
            Nutritional::where('id', $product['nutritional_id'])->update([
                'proteins' => $data['proteins'],
                'fats' => $data['fats'],
                'carbohydrates' => $data['carbohydrates'],
            ]);
            $nutritional = Nutritional::find($product['nutritional_id']);
            $product['nutritional'] = $nutritional;
            return $product;
        }, 2);
        return new ProductsResource($updatedProduct);
    }

    public function monthlyBestSelling(int $year, int $month): array
    {
        $ordersId = Order::whereBetween('created_at', [
            $year.'-'.$month.'-01 00:00:00', $year.'-'.$month.'-31 00:00:00'
        ])->latest()->pluck('id');
        $stashProducts = [];
        $data = [];
        foreach($ordersId as $orderId) {
            $products = OrderProduct::with('product:id,name')
                ->where('order_id', $orderId)
                ->get();
            foreach($products as $product) {
                if (isset($stashProducts[$product->id])) {
                    $stashProducts[$product->id]['count'] + $product->count;
                }
                else {
                    $stashProducts[$product->id]['count'] = $product->count;
                }
                $stashProducts[$product->id]['id'] = $product->product->id;
                $stashProducts[$product->id]['name'] = $product->product->name;
            }
        }
        uasort($stashProducts, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        foreach($stashProducts as $item) $data[] = $item;
        return $stashProducts;
    }
}
