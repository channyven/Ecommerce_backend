<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List all active categories (parents with children nested).
     *
     * GET /api/categories
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::active()
            ->parents()
            ->ordered()
            ->with(['children' => function ($q) {
                $q->active()->ordered()->withCount('products');
            }])
            ->withCount('products')
            ->get();

        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Get a single category by slug with its products.
     *
     * GET /api/categories/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->with('children')
            ->firstOrFail();

        $products = $category->products()
            ->active()
            ->with('primaryImage')
            ->paginate(12);

        return response()->json([
            'data' => [
                'category' => new CategoryResource($category),
                'products' => $products,
            ],
        ]);
    }
}
