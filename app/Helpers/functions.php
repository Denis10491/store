<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

function uploadImage(Request $request): ?string
{
    if ($request->hasFile('image')) {
        $path = $request->file('image')->storePublicly('images', 'public');
        Storage::disk('public')->url($path);
        return $path;
    }
    return null;
}

function responseOk(): JsonResponse
{
    return response()->json(['message' => 'Success']);
}
