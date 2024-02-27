<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()->latest()->get();
        return response()->json(ProductResource::collection($products));
    }

    public function show(Product $product): JsonResponse
    {
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
        return response()->json(['message' => 'Success']);
    }
}
