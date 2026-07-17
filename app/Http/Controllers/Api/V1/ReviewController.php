<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $hasPurchased = Order::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->whereHas('items', fn ($query) => $query->where('product_id', $request->input('product_id')))
            ->exists();

        if (! $hasPurchased) {
            return response()->json(['message' => 'You can only review purchased products'], 403);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $request->input('product_id'),
            'rating' => $request->input('rating', 5),
            'comment' => $request->input('comment'),
        ]);

        return response()->json(['message' => 'Review created', 'review' => $review], 201);
    }
}
