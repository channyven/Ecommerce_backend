<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the review for API responses.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'rating'               => $this->rating,
            'title'                => $this->title,
            'content'              => $this->content,
            'is_verified_purchase' => $this->is_verified_purchase,
            'user'                 => $this->when($this->relationLoaded('user'), function () {
                return [
                    'id'   => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
