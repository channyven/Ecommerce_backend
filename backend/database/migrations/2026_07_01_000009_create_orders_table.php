<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the orders table.
     *
     * Key design decisions:
     * - order_number is a human-readable unique identifier (e.g., ORD-001)
     * - Status tracking uses separate fields for order status and payment status
     * - Financial fields (subtotal, tax, shipping, discount, total) are all stored
     *   as decimals to avoid float precision issues with money
     * - coupon_id is nullable — only set when a coupon was applied
     * - Shipping and billing addresses are stored as foreign keys,
     *   but we'll also snapshot the address data in case the user changes their address later
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete(); // Keep orders even if user is deleted
            $table->string('order_number')->unique();
            $table->string('status', 50)->default('pending'); // pending, confirmed, processing, shipped, delivered, cancelled
            $table->string('payment_status', 50)->default('pending'); // pending, paid, failed, refunded
            $table->string('payment_method', 50)->nullable(); // cod, bank_transfer, card, etc.
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->foreignId('coupon_id')->nullable()
                ->constrained()
                ->nullOnDelete(); // Keep order even if coupon is deleted
            $table->text('notes')->nullable();
            $table->foreignId('shipping_address_id')->nullable()
                ->constrained('addresses')
                ->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()
                ->constrained('addresses')
                ->nullOnDelete();
            $table->timestamps();

            // Indexes for common queries
            $table->index('status');
            $table->index('payment_status');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
