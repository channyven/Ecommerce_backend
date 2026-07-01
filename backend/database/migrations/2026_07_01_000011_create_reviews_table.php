<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the reviews table.
     *
     * Key design decisions:
     * - One review per user per product (unique constraint on user_id + product_id)
     *   This prevents spam and ensures each user can only review a product once.
     * - order_id links the review to the specific purchase for verified purchase badge
     * - status: pending (needs admin approval), approved (visible), rejected (hidden)
     * - is_verified_purchase: TRUE if the user actually bought this product
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->unsignedTinyInteger('rating'); // 1-5 stars
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('status', 50)->default('pending'); // pending, approved, rejected
            $table->boolean('is_verified_purchase')->default(false);
            $table->timestamps();

            // One review per user per product
            $table->unique(['user_id', 'product_id']);

            // Index for common queries
            $table->index(['product_id', 'status']); // Show approved reviews on product page
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
