<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wishlist extends Model
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
     * A wishlist belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A wishlist has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }
}
