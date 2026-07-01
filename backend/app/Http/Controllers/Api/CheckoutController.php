<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Process the checkout — create an order from the cart contents.
     *
     * POST /api/checkout
     */
    public function store(CheckoutRequest $request): JsonResponse
    {
        $user = $request->user();

        // Get the user's cart with items and products
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        // Validate stock availability
        foreach ($cart->items as $item) {
            if (! $item->product->is_active || $item->product->quantity < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for {$item->product->name}. Available: {$item->product->quantity}.",
                ], 400);
            }
        }

        // Calculate totals
        $subtotal = $cart->items->sum(fn ($i) => $i->product->price * $i->quantity);
        $discountAmount = 0;

        // Apply coupon if provided
        $coupon = null;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();

            if (! $coupon || ! $coupon->is_valid) {
                return response()->json(['message' => 'Invalid or expired coupon.'], 400);
            }

            if ($subtotal < $coupon->min_order_amount) {
                return response()->json([
                    'message' => "Minimum order amount of \${$coupon->min_order_amount} required for this coupon.",
                ], 400);
            }

            $discountAmount = $coupon->type === 'percentage'
                ? $subtotal * ($coupon->value / 100)
                : min($coupon->value, $subtotal);
        }

        $taxAmount = round($subtotal * 0.08, 2); // 8% tax rate
        $shippingAmount = $subtotal >= 100 ? 0 : 9.99; // Free shipping over $100
        $total = round(($subtotal + $taxAmount + $shippingAmount) - $discountAmount, 2);

        // Generate order number
        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        // Validate address ownership
        $shippingAddress = Address::where('id', $request->shipping_address_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Use billing address = shipping address if not provided
        $billingAddressId = $request->billing_address_id ?? $request->shipping_address_id;

        if ($request->billing_address_id) {
            Address::where('id', $request->billing_address_id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        DB::beginTransaction();
        try {
            // Create the order
            $order = Order::create([
                'user_id'             => $user->id,
                'order_number'        => $orderNumber,
                'status'              => 'pending',
                'payment_status'      => 'pending',
                'payment_method'      => $request->payment_method ?? 'cod',
                'subtotal'            => $subtotal,
                'tax_amount'          => $taxAmount,
                'shipping_amount'     => $shippingAmount,
                'discount_amount'     => $discountAmount,
                'total'               => $total,
                'coupon_id'           => $coupon?->id,
                'notes'               => $request->notes,
                'shipping_address_id' => $request->shipping_address_id,
                'billing_address_id'  => $billingAddressId,
            ]);

            // Create order items from cart items
            foreach ($cart->items as $item) {
                $product = $item->product;

                $order->items()->create([
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_price' => $product->price,
                    'quantity'      => $item->quantity,
                    'unit_price'    => $product->price,
                    'subtotal'      => $product->price * $item->quantity,
                ]);

                // Decrement stock
                $product->decrement('quantity', $item->quantity);
            }

            // Increment coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Clear the cart
            $cart->items()->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Checkout failed. Please try again.'], 500);
        }

        $order->load('items');

        return response()->json([
            'message' => 'Order placed successfully!',
            'data'    => new OrderResource($order),
        ], 201);
    }
}
