<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Get approved reviews for a product.
     *
     * GET /api/products/{product}/reviews
     */
    public function index(Product $product): JsonResponse
    {
        $reviews = $product->reviews()
            ->approved()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => ReviewResource::collection($reviews),
            'meta' => [
                'average_rating' => round($product->reviews()->approved()->avg('rating'), 1),
                'total_reviews'  => $product->reviews()->approved()->count(),
                'current_page'   => $reviews->currentPage(),
                'last_page'      => $reviews->lastPage(),
            ],
        ]);
    }

    /**
     * Submit a review for a product (authenticated).
     *
     * POST /api/reviews
     */
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $user = $request->user();

        // Check if user already reviewed this product
        $existing = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already reviewed this product.'], 409);
        }

        // Check if user purchased this product (verified purchase)
        $purchased = Order::where('user_id', $user->id)
            ->whereHas('items', fn ($q) => $q->where('product_id', $request->product_id))
            ->exists();

        $review = Review::create([
            'user_id'             => $user->id,
            'product_id'          => $request->product_id,
            'rating'              => $request->rating,
            'title'               => $request->title,
            'content'             => $request->content,
            'status'              => 'approved', // Auto-approve for now; could be 'pending' for admin moderation
            'is_verified_purchase' => $purchased,
        ]);

        $review->load('user');

        return response()->json([
            'message' => 'Review submitted successfully.',
            'data'    => new ReviewResource($review),
        ], 201);
    }
}
