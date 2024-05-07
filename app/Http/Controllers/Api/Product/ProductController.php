<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\MinifiedProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role.admin'])->only('store', 'update', 'destroy');
    }

    public function index(): JsonResponse
    {
        $products = Cache::remember('products.index', 60, static function () {
            return Product::query()->inStock()->latest()->get();
        });

        if (auth()->user()?->isAdmin()) {
            $products = Product::query()->latest()->get();
        }

        return response()->json(MinifiedProductResource::collection($products));
    }

    public function show(Product $product): JsonResponse
    {
        Cache::remember('products.show.'.$product->id, 60, static function () use ($product) {
            return $product;
        });
        return response()->json(new ProductResource($product));
    }

    public function store(StoreProductRequest $request, ProductServiceContract $service): JsonResponse
    {
        $createdProduct = $service->store($request);
        return response()->json(new ProductResource($createdProduct), 201);
    }

    public function update(
        UpdateProductRequest $request,
        ProductServiceContract $service,
        Product $product
    ): JsonResponse {
        $updatedProduct = $service->setProduct($product)->update($request);
        return response()->json(new ProductResource($updatedProduct));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return responseOk();
    }
}
