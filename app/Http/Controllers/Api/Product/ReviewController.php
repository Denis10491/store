<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ReviewServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateReviewRequest;
use App\Http\Resources\Product\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, ReviewServiceContract $service, Product $product): JsonResponse
    {
        $createdReview = $service->setProduct($product)->store($request);
        return response()->json(new ReviewResource($createdReview), 201);
    }

    public function update(UpdateReviewRequest $request, ReviewServiceContract $service, Review $review): JsonResponse
    {
        $updatedReview = $service->setReview($review)->update($request);
        return response()->json(new ReviewResource($updatedReview));
    }

    public function destroy(Review $review): JsonResponse
    {
        Gate::authorize('delete-review');
        $review->delete();
        return responseOk();
    }
}
