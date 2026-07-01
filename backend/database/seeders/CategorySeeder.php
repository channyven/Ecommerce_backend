<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates a skincare-focused category hierarchy.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cleansers',
                'children' => [
                    ['name' => 'Foaming Cleansers'],
                    ['name' => 'Oil-Based Cleansers'],
                    ['name' => 'Micellar Water'],
                    ['name' => 'Exfoliating Cleansers'],
                ],
            ],
            [
                'name' => 'Moisturizers',
                'children' => [
                    ['name' => 'Day Creams'],
                    ['name' => 'Night Creams'],
                    ['name' => 'Gel Moisturizers'],
                    ['name' => 'Face Oils'],
                ],
            ],
            [
                'name' => 'Serums & Treatments',
                'children' => [
                    ['name' => 'Vitamin C Serums'],
                    ['name' => 'Hyaluronic Acid'],
                    ['name' => 'Retinol Treatments'],
                    ['name' => 'Niacinamide'],
                ],
            ],
            [
                'name' => 'Sunscreens',
                'children' => [
                    ['name' => 'SPF 30+'],
                    ['name' => 'SPF 50+'],
                    ['name' => 'Tinted Sunscreens'],
                    ['name' => 'Body Sunscreens'],
                ],
            ],
            [
                'name' => 'Masks & Treatments',
                'children' => [
                    ['name' => 'Sheet Masks'],
                    ['name' => 'Clay Masks'],
                    ['name' => 'Sleeping Masks'],
                    ['name' => 'Peel-Off Masks'],
                ],
            ],
            [
                'name' => 'Toners & Essences',
                'children' => [
                    ['name' => 'Hydrating Toners'],
                    ['name' => 'Exfoliating Toners'],
                    ['name' => 'Essences'],
                    ['name' => 'Mists'],
                ],
            ],
            [
                'name' => 'Eye & Lip Care',
                'children' => [
                    ['name' => 'Eye Creams'],
                    ['name' => 'Lip Balms & Treatments'],
                    ['name' => 'Eye Serums'],
                    ['name' => 'Lip Masks'],
                ],
            ],
            [
                'name' => 'Body Care',
                'children' => [
                    ['name' => 'Body Lotions'],
                    ['name' => 'Body Washes'],
                    ['name' => 'Hand Creams'],
                    ['name' => 'Body Scrubs'],
                ],
            ],
        ];

        $sortOrder = 0;
        foreach ($categories as $parentData) {
            $sortOrder += 10;

            $parent = Category::create([
                'name'       => $parentData['name'],
                'slug'       => Str::slug($parentData['name']),
                'is_active'  => true,
                'sort_order' => $sortOrder,
            ]);

            $childSort = 0;
            foreach ($parentData['children'] as $childData) {
                $childSort += 10;

                Category::create([
                    'name'       => $childData['name'],
                    'slug'       => Str::slug($childData['name']),
                    'parent_id'  => $parent->id,
                    'is_active'  => true,
                    'sort_order' => $childSort,
                ]);
            }
        }
    }
}
