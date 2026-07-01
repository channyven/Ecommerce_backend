<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Creates:
     * - 1 admin user (admin@admin.com / password)
     * - 1 test customer (customer@test.com / password)
     * - 5 parent categories + 20 child categories
     * - 31 sample products across all categories
     */
    public function run(): void
    {
        // ── Admin User ──
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'phone'    => '+1-555-0100',
            'is_admin' => true,
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        // ── Test Customer ──
        User::factory()->create([
            'name'     => 'John Customer',
            'email'    => 'customer@test.com',
            'password' => Hash::make('password'),
            'phone'    => '+1-555-0101',
            'is_admin' => false,
            'role'     => 'customer',
            'status'   => 'active',
        ]);

        // ── Categories & Products ──
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
        ]);
    }
}
