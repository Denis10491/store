<?php

namespace App\Contracts;

use App\Http\Requests\ProductStatisticsMonthlyBestSellingRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceContract
{
    public function store(StoreProductRequest $request): Product;

    public function update(UpdateProductRequest $request): Product;

    public function monthlyBestSelling(ProductStatisticsMonthlyBestSellingRequest $request): Collection;

    public function setProduct(Product $product): static;
}
