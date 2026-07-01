<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the order_items table.
     *
     * Key design decisions:
     * - product_name and product_price are SNAPSHOTS of the product data
     *   at the time of purchase. This is critical because:
     *   1. Products can change name or price after an order is placed
     *   2. Products can be deleted (soft or hard)
     *   3. Order history must always show what the customer actually paid
     * - product_id is nullable so the order item survives product deletion
     * - unit_price vs product_price: unit_price is what was charged (might differ
     *   from product_price due to discounts, promotions, etc.)
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete(); // Delete items when order is deleted
            $table->foreignId('product_id')->nullable()
                ->constrained()
                ->nullOnDelete(); // Keep item even if product is deleted
            $table->string('product_name'); // Snapshot: name at time of purchase
            $table->decimal('product_price', 10, 2); // Snapshot: price at time of purchase
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Actual price charged
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
