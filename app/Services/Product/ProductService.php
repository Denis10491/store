<?php

namespace App\Services\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Requests\Product\ProductStatisticsMonthlyBestSellingRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Nutritional;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function uploadImage;

class ProductService implements ProductServiceContract
{
    protected Product $product;

    public function store(StoreProductRequest $request): Product
    {
        return DB::transaction(static function () use ($request): Product {
            $path = uploadImage($request);
            $nutritional = Nutritional::query()->create($request->only('proteins', 'fats', 'carbohydrates'));
            return Product::query()->create([
                ...$request->only('name', 'description', 'composition', 'price'),
                'imgPath' => config('app.url').Storage::url($path),
                'nutritional_id' => $nutritional->id,
            ]);
        });
    }

    public function update(UpdateProductRequest $request): Product
    {
        return DB::transaction(function () use ($request): Product {
            $path = uploadImage($request);
            if ($path) {
                $this->product->update(['imgPath' => 'storage/'.$path]);
            }

            if ($request->method() === 'PUT') {
                $this->product->update([
                    'name' => $request->str('name'),
                    'description' => $request->str('description'),
                    'composition' => $request->str('composition'),
                    'price' => $request->integer('price'),
                ]);
                $this->product->nutritional()->update([
                    'proteins' => $request->integer('proteins'),
                    'fats' => $request->integer('fats'),
                    'carbohydrates' => $request->integer('carbohydrates'),
                ]);
            } else {
                $this->product->update($request->only('name', 'description', 'composition', 'price'));
                $this->product->nutritional()->update($request->only('proteins', 'fats', 'carbohydrates'));
            }

            return $this->product;
        });
    }

    public function monthlyBestSelling(ProductStatisticsMonthlyBestSellingRequest $request
    ): Collection {
        $date = $request->integer('year').'-'.$request->integer('month');
        return Order::query()->whereBetween('created_at',
            [
                Carbon::parse($date)->startOfMonth(),
                Carbon::parse($date)->endOfMonth()
            ])
            ->with('products')
            ->selectRaw('order_product.product_id, SUM(order_product.count) as total_count')
            ->groupBy('order_product.product_id')->get();
    }

    public function setProduct(Product $product): static
    {
        $this->product = $product;
        return $this;
    }
}
