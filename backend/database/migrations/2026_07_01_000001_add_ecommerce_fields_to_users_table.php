<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: add e-commerce specific columns to users table.
     *
     * These columns extend the default Laravel users table with
     * e-commerce functionality: admin flag, contact info, and status.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->boolean('is_admin')->default(false)->after('avatar');
            $table->string('role', 50)->default('customer')->after('is_admin');
            $table->string('status', 50)->default('active')->after('role');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'is_admin', 'role', 'status']);
            $table->dropSoftDeletes();
        });
    }
};
