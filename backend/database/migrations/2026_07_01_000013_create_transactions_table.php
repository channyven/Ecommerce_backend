<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the transactions table.
     *
     * Tracks payment gateway transactions for each order.
     * gateway: the payment processor (stripe, paypal, etc.)
     * gateway_reference: the transaction ID from the payment processor
     * type: 'payment' or 'refund'
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('type', 50); // payment, refund
            $table->decimal('amount', 10, 2);
            $table->string('status', 50)->default('pending'); // pending, completed, failed
            $table->string('gateway', 50)->nullable();
            $table->string('gateway_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
