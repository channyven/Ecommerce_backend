<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Lightweight product resource for list endpoints.
     * Excludes full description to keep response sizes small.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'short_description' => $this->short_description,
            'price'           => (float) $this->price,
            'compare_price'   => (float) $this->compare_price,
            'has_discount'    => $this->has_discount,
            'discount_percent' => $this->discount_percent,
            'in_stock'        => $this->in_stock,
            'quantity'        => $this->quantity,
            'is_featured'     => $this->is_featured,
            'primary_image'   => $this->when($this->relationLoaded('primaryImage') && $this->primaryImage, function () {
                $path = $this->primaryImage->path;
                return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
            }),
            'category'        => new CategoryResource($this->whenLoaded('category')),
            'created_at'      => $this->created_at->toISOString(),
        ];
    }
}
