<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: create the addresses table.
     *
     * Key design decisions:
     * - type field distinguishes between 'shipping' and 'billing' addresses
     * - is_default allows users to have a default address auto-selected during checkout
     * - full_name stored separately from user's name (for gift shipments, etc.)
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete(); // Remove addresses when user is deleted
            $table->string('type', 50)->default('shipping'); // shipping, billing
            $table->string('full_name');
            $table->string('phone', 20)->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('postal_code', 20)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
