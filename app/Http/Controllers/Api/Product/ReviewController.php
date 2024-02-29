<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Resources\Product\ReviewResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, ProductServiceContract $service, Product $product): JsonResponse
    {
        $createdReview = $service->setProduct($product)->storeReview($request);
        return response()->json(new ReviewResource($createdReview), 201);
    }
}
