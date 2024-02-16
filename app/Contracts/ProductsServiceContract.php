<?php

namespace App\Contracts;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsCollection;
use App\Http\Resources\ProductsResource;
use Illuminate\Support\Collection;

interface ProductsServiceContract
{
    public function create(array $data, StoreProductRequest $request): ProductsResource;
    public function update(array $data, UpdateProductRequest $request, string $id): ProductsResource;
    public function monthlyBestSelling(int $year, int $month): array;
}