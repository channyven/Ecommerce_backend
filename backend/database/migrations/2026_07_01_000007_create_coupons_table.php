<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the coupons table.
     *
     * Key design decisions:
     * - type: 'percentage' (e.g., 10% off) or 'fixed' (e.g., $5 off)
     * - value: the actual discount amount (e.g., 10 for 10%, 5.00 for $5 off)
     * - min_order_amount: minimum cart total required to use this coupon
     * - max_uses: global limit on how many times the coupon can be used
     * - used_count: tracks current usage count
     * - starts_at / expires_at: date range for the coupon validity
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('type', 20); // percentage, fixed
            $table->decimal('value', 10, 2);
            $table->string('description')->nullable();
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['code', 'is_active', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
