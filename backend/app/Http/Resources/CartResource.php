<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the cart into a clean API response.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'items'          => $this->when($this->relationLoaded('items'), function () {
                return $this->items->map(fn ($item) => [
                    'id'         => $item->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'product'    => $item->relationLoaded('product') ? [
                        'name'       => $item->product->name,
                        'slug'       => $item->product->slug,
                        'price'      => (float) $item->product->price,
                        'image'      => $item->product->relationLoaded('primaryImage') && $item->product->primaryImage
                            ? asset('storage/' . $item->product->primaryImage->path)
                            : null,
                        'in_stock'   => $item->product->in_stock,
                    ] : null,
                    'subtotal'   => (float) $item->subtotal,
                ]);
            }),
            'total'          => (float) $this->total,
            'total_quantity' => $this->total_quantity,
        ];
    }
}
