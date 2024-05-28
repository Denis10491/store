<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\MinifiedProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Cache::remember('products.index', 60, static function () {
            return Product::query()->inStock()->latest()->get();
        });

        if (Gate::check('read-product-amount')) {
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
        if (Gate::denies('delete-product')) {
            throw new ForbiddenException();
        }

        $product->delete();
        return responseOk();
    }
}
