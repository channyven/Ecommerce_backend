<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Full product resource for detail pages.
     * Includes all images, reviews summary, and category info.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'short_description' => $this->short_description,
            'price'           => (float) $this->price,
            'compare_price'   => (float) $this->compare_price,
            'has_discount'    => $this->has_discount,
            'discount_percent' => $this->discount_percent,
            'in_stock'        => $this->in_stock,
            'quantity'        => $this->quantity,
            'sku'             => $this->sku,
            'barcode'         => $this->barcode,
            'is_featured'     => $this->is_featured,
            'category'        => new CategoryResource($this->whenLoaded('category')),
            'images'          => $this->when($this->relationLoaded('images'), function () {
                return $this->images->map(fn ($img) => [
                    'id'         => $img->id,
                    'url'        => str_starts_with($img->path, 'http') ? $img->path : asset('storage/' . $img->path),
                    'alt'        => $img->alt,
                    'is_primary' => $img->is_primary,
                    'sort_order' => $img->sort_order,
                ]);
            }),
            'reviews_summary' => $this->when($this->relationLoaded('reviews'), function () {
                return [
                    'total'    => $this->reviews->count(),
                    'average'  => round($this->reviews->avg('rating'), 1),
                    'ratings'  => $this->reviews->groupBy('rating')->map->count(),
                ];
            }),
            'created_at'      => $this->created_at->toISOString(),
        ];
    }
}
