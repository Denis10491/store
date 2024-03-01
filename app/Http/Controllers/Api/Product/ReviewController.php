<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateReviewRequest;
use App\Http\Resources\Product\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('access.review')->only('update', 'destroy');
    }

    public function store(StoreReviewRequest $request, ProductServiceContract $service, Product $product): JsonResponse
    {
        $createdReview = $service->setProduct($product)->storeReview($request);
        return response()->json(new ReviewResource($createdReview), 201);
    }

    public function update(UpdateReviewRequest $request, ProductServiceContract $service, Review $review): JsonResponse
    {
        $updatedReview = $service->setReview($review)->updateReview($request);
        return response()->json(new ReviewResource($updatedReview));
    }

    public function destroy(Review $review): JsonResponse
    {
        $review->delete();
        return response()->json(['message' => 'Success']);
    }
}
