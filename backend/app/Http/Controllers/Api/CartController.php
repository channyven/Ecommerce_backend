<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCartItemRequest;
use App\Http\Resources\CartResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get the authenticated user's cart with items and totals.
     *
     * GET /api/cart
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $request->user()->cart()
            ->with('items.product.primaryImage')
            ->first();

        if (! $cart) {
            return response()->json(['data' => [
                'items'          => [],
                'total'          => 0,
                'total_quantity' => 0,
            ]]);
        }

        return response()->json([
            'data' => new CartResource($cart),
        ]);
    }

    /**
     * Add an item to the cart (or update quantity if already in cart).
     *
     * POST /api/cart
     */
    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $product = \App\Models\Product::findOrFail($request->product_id);

        if (! $product->is_active || $product->quantity < 1) {
            return response()->json(['message' => 'Product is not available.'], 400);
        }

        $cart = $request->user()->cart()->firstOrCreate();
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            // Update quantity of existing item
            $newQty = $item->quantity + $request->quantity;
            if ($newQty > $product->quantity) {
                return response()->json([
                    'message' => 'Requested quantity exceeds available stock (' . $product->quantity . ').',
                ], 400);
            }

            $item->update(['quantity' => $newQty]);
            $msg = 'Cart updated.';
        } else {
            if ($request->quantity > $product->quantity) {
                return response()->json([
                    'message' => 'Requested quantity exceeds available stock (' . $product->quantity . ').',
                ], 400);
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
            $msg = 'Added to cart.';
        }

        $cart->load('items.product.primaryImage');

        return response()->json([
            'message' => $msg,
            'data'    => new CartResource($cart),
        ]);
    }

    /**
     * Update the quantity of a specific cart item.
     *
     * PUT /api/cart/{cartItem}
     */
    public function update(StoreCartItemRequest $request, \App\Models\CartItem $cartItem): JsonResponse
    {
        // Ensure the item belongs to the authenticated user
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $product = $cartItem->product;

        if ($request->quantity > $product->quantity) {
            return response()->json([
                'message' => 'Requested quantity exceeds available stock (' . $product->quantity . ').',
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cartItem->cart->load('items.product.primaryImage');

        return response()->json([
            'message' => 'Cart updated.',
            'data'    => new CartResource($cartItem->cart),
        ]);
    }

    /**
     * Remove an item from the cart.
     *
     * DELETE /api/cart/{cartItem}
     */
    public function destroy(Request $request, \App\Models\CartItem $cartItem): JsonResponse
    {
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->load('items.product.primaryImage');

        return response()->json([
            'message' => 'Item removed from cart.',
            'data'    => new CartResource($cart),
        ]);
    }
}
