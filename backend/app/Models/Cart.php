<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
    ];

    // ──────────────────────────────
    // Relationships
    // ──────────────────────────────

    /**
     * A cart belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A cart has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // ──────────────────────────────
    // Accessors
    // ──────────────────────────────

    /**
     * Calculate the total price of all items in the cart.
     * Uses load() which is idempotent — won't re-query if already loaded.
     */
    public function getTotalAttribute(): float
    {
        $this->load('items.product');

        return $this->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Count total items in the cart.
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}
