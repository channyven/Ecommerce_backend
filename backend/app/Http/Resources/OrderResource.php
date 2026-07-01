<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the order for API responses.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'order_number'   => $this->order_number,
            'status'         => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'subtotal'       => (float) $this->subtotal,
            'tax_amount'     => (float) $this->tax_amount,
            'shipping_amount' => (float) $this->shipping_amount,
            'discount_amount' => (float) $this->discount_amount,
            'total'          => (float) $this->total,
            'notes'          => $this->notes,
            'items'          => $this->when($this->relationLoaded('items'), function () {
                return $this->items->map(fn ($item) => [
                    'product_name'  => $item->product_name,
                    'product_price' => (float) $item->product_price,
                    'quantity'      => $item->quantity,
                    'unit_price'    => (float) $item->unit_price,
                    'subtotal'      => (float) $item->subtotal,
                ]);
            }),
            'shipping_address' => $this->when($this->relationLoaded('shippingAddress'), function () {
                return $this->shippingAddress ? [
                    'full_name'     => $this->shippingAddress->full_name,
                    'address_line1' => $this->shippingAddress->address_line1,
                    'address_line2' => $this->shippingAddress->address_line2,
                    'city'          => $this->shippingAddress->city,
                    'state'         => $this->shippingAddress->state,
                    'country'       => $this->shippingAddress->country,
                    'postal_code'   => $this->shippingAddress->postal_code,
                    'phone'         => $this->shippingAddress->phone,
                ] : null;
            }),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
