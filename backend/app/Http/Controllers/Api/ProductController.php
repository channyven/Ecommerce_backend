<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List active products with optional filters.
     *
     * GET /api/products
     * Query params: category_id, featured, min_price, max_price, sort, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()
            ->with('category', 'primaryImage');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        // Filter featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        $perPage = min((int) $request->input('per_page', 12), 50);
        $products = $query->paginate($perPage);

        return response()->json([
            'data' => ProductListResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'total'        => $products->total(),
                'per_page'     => $products->perPage(),
            ],
        ]);
    }

    /**
     * Get a single product by slug with full details.
     *
     * GET /api/products/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['category', 'images', 'reviews' => function ($q) {
                $q->approved()->with('user');
            }])
            ->firstOrFail();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Search products by name, description, or SKU.
     *
     * GET /api/products/search?q=keyword
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2|max:100']);

        $products = Product::active()
            ->with('category', 'primaryImage')
            ->search($request->q)
            ->paginate(12);

        return response()->json([
            'data' => ProductListResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'total'        => $products->total(),
                'query'        => $request->q,
            ],
        ]);
    }
}
