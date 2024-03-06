<?php

namespace App\Contracts;

use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;

interface ReviewServiceContract
{
    public function store(StoreReviewRequest $request): Review;

    public function update(UpdateReviewRequest $request): Review;

    public function setProduct(Product $product): static;
    
    public function setReview(Review $review): static;
}
