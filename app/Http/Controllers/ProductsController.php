<?php

namespace App\Http\Controllers;

use App\Contracts\ProductsServiceContract;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsCollection;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $page): Response
    {
        $products = Product::with('nutritional')->orderBy('id', 'DESC')->paginate(30, ['*'], 'page', (int) $page);
        return response([
            'status' => true,
            'data' => new ProductsCollection($products)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, ProductsServiceContract $service): Response
    {
        return response([
            'status' => true, 
            'data' => $service->create($request->validated(), $request)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
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
    public function update(UpdateProductRequest $request, ProductsServiceContract $service, string $id): Response
    {
        return response([
            'status' => true, 
            'data' => $service->update($request->validated(), $request, $id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        return response(['status' => Product::destroy($id)]);
    }
}