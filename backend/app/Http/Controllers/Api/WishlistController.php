<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get the authenticated user's wishlist with products.
     *
     * GET /api/wishlist
     */
    public function index(Request $request): JsonResponse
    {
        $wishlist = $request->user()->wishlist()
            ->with('items.product.primaryImage')
            ->first();

        if (! $wishlist) {
            return response()->json(['data' => []]);
        }

        return response()->json([
            'data' => $wishlist->items->map(fn ($item) => [
                'id'         => $item->id,
                'product_id' => $item->product_id,
                'product'    => $item->relationLoaded('product') && $item->product ? [
                    'id'        => $item->product->id,
                    'name'      => $item->product->name,
                    'slug'      => $item->product->slug,
                    'price'     => (float) $item->product->price,
                    'in_stock'  => $item->product->in_stock,
                    'image'     => $item->product->relationLoaded('primaryImage') && $item->product->primaryImage
                        ? asset('storage/' . $item->product->primaryImage->path)
                        : null,
                ] : null,
                'created_at' => $item->created_at->toISOString(),
            ]),
        ]);
    }

    /**
     * Add a product to the wishlist.
     *
     * POST /api/wishlist
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $wishlist = $request->user()->wishlist()->firstOrCreate();

        // Check if already in wishlist
        $existing = $wishlist->items()->where('product_id', $request->product_id)->first();
        if ($existing) {
            return response()->json([
                'message' => 'Product already in wishlist.',
                'data'    => ['id' => $existing->id],
            ]);
        }

        $item = $wishlist->items()->create([
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'message' => 'Added to wishlist.',
            'data'    => ['id' => $item->id],
        ], 201);
    }

    /**
     * Remove a product from the wishlist.
     *
     * DELETE /api/wishlist/{productId}
     */
    public function destroy(Request $request, Product $product): JsonResponse
    {
        $wishlist = $request->user()->wishlist()->first();

        if (! $wishlist) {
            return response()->json(['message' => 'Wishlist is empty.'], 404);
        }

        $deleted = $wishlist->items()->where('product_id', $product->id)->delete();

        if (! $deleted) {
            return response()->json(['message' => 'Product not in wishlist.'], 404);
        }

        return response()->json(['message' => 'Removed from wishlist.']);
    }
}
