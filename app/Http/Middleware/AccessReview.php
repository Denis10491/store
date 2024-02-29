<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessReview
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $review = $request->route('review');

        if (!auth()->user()->isAdmin() && auth()->user()->id !== $review->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
