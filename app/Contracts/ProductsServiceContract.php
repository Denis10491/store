<?php

namespace App\Contracts;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;

interface ProductsServiceContract
{
    public function create(array $data, StoreProductRequest $request): ProductsResource;
    public function update(array $data, UpdateProductRequest $request, string $id): ProductsResource;
}