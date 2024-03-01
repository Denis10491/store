<?php

namespace App\Contracts;

use App\Http\Requests\Product\ProductStatisticsMonthlyBestSellingRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Collection;

interface ProductServiceContract
{
    public function store(StoreProductRequest $request): Product;

    public function storeReview(StoreReviewRequest $request): Review;

    public function update(UpdateProductRequest $request): Product;

    public function updateReview(UpdateReviewRequest $request): Review;

    public function monthlyBestSelling(ProductStatisticsMonthlyBestSellingRequest $request): Collection;

    public function setProduct(Product $product): static;

    public function setReview(Review $review): static;
}
