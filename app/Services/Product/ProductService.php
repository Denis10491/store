<?php

namespace App\Services\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Requests\Product\ProductStatisticsMonthlyBestSellingRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Nutritional;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductServiceContract
{
    protected Product $product;

    public function store(StoreProductRequest $request): Product
    {
        return DB::transaction(static function () use ($request): Product {
            $path = $request->file('image')->storePublicly('images', 'public');
            Storage::disk('public')->url($path);

            $nutritional = Nutritional::query()->create([
                'proteins' => $request->integer('proteins'),
                'fats' => $request->integer('fats'),
                'carbohydrates' => $request->integer('carbohydrates')
            ]);

            return Product::query()->create([
                'name' => $request->str('name'),
                'description' => $request->str('description'),
                'imgPath' => config('app.url').Storage::url($path),
                'nutritional_id' => $nutritional->id,
                'composition' => $request->str('composition'),
                'price' => $request->str('price')
            ]);
        });
    }

    public function storeReview(StoreReviewRequest $request): Review
    {
        return DB::transaction(function () use ($request): Review {
            return auth()->user()->reviews()->create([
                'body' => $request->str('body'),
                'rating' => $request->integer('rating'),
                'product_id' => $this->product->id
            ]);
        });
    }


    public function update(UpdateProductRequest $request): Product
    {
        return DB::transaction(function () use ($request): Product {
            if ($request->file('image')) {
                $path = $request->file('image')->storePublicly('images', 'public');
                Storage::disk('public')->url($path);
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
                $data = [];

                if ($request->has('name')) {
                    $data['name'] = $request->str('name');
                }

                if ($request->has('description')) {
                    $data['description'] = $request->str('description');
                }

                if ($request->has('composition')) {
                    $data['composition'] = $request->str('composition');
                }

                if ($request->has('price')) {
                    $data['price'] = $request->integer('price');
                }

                $this->product->update($data);

                $data = [];

                if ($request->has('proteins')) {
                    $data['proteins'] = $request->integer('proteins');
                }

                if ($request->has('fats')) {
                    $data['fats'] = $request->integer('fats');
                }

                if ($request->has('carbohydrates')) {
                    $data['carbohydrates'] = $request->integer('carbohydrates');
                }

                $this->product->nutritional()->update($data);
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
