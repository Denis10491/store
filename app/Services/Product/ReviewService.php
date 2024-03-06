<?php

namespace App\Services\Product;

use App\Contracts\ReviewServiceContract;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;

class ReviewService implements ReviewServiceContract
{
    protected Review $review;

    public function store(StoreReviewRequest $request): Review
    {
        return auth()->user()->reviews()->create([
            ...$request->only('body', 'rating'),
            'product_id' => $this->product->id
        ]);
    }

    public function update(UpdateReviewRequest $request): Review
    {
        if ($request->method() === 'PUT') {
            $this->review->update([
                'body' => $request->str('body'),
                'rating' => $request->integer('rating')
            ]);
        } else {
            $this->review->update($request->only('body', 'rating'));
        }
        return $this->review;
    }

    public function setProduct(Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function setReview(Review $review): static
    {
        $this->review = $review;
        return $this;
    }
}
