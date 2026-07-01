<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'description',
        'min_order_amount',
        'max_uses',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_uses' => 'integer',
            'used_count' => 'integer',
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // ──────────────────────────────
    // Accessors
    // ──────────────────────────────

    /**
     * Check if the coupon is currently valid.
     */
    public function getIsValidAttribute(): bool
    {
        $now = Carbon::now();

        return $this->is_active
            && ($this->max_uses === null || $this->used_count < $this->max_uses)
            && ($this->starts_at === null || $now >= $this->starts_at)
            && ($this->expires_at === null || $now <= $this->expires_at);
    }

    // ──────────────────────────────
    // Scopes
    // ──────────────────────────────

    /**
     * Scope a query to only include valid coupons.
     */
    public function scopeValid($query)
    {
        $now = Carbon::now();

        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('max_uses')
                  ->orWhereColumn('used_count', '<', 'max_uses');
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', $now);
            });
    }
}
