<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the carts and cart_items tables.
     *
     * Key design decisions:
     * - Each user has ONE cart (user_id is unique on carts)
     * - Cart items reference the product and store quantity
     * - No unit_price on cart_items — we pull the current price from products
     *   at checkout time. This ensures the price is always up-to-date.
     * - Cascade delete: when a user is deleted, their cart is removed.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete(); // Remove items when cart is deleted
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete(); // Prevent deleting a product that's in a cart
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // A product can only appear once in a cart
            $table->unique(['cart_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
