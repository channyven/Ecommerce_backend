<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): View
    {
        $products = Product::with('category', 'primaryImage')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'name'             => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description'      => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price'            => ['required', 'numeric', 'min:0'],
            'compare_price'    => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'quantity'         => ['required', 'integer', 'min:0'],
            'sku'              => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'barcode'          => ['nullable', 'string', 'max:100'],
            'is_featured'      => ['boolean'],
            'is_active'        => ['boolean'],
            'status'           => ['nullable', 'string', 'max:50'],
            'images'           => ['nullable', 'array'],
            'images.*'         => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $validated['slug'] ??= Str::slug($validated['name']);
        $validated['is_featured'] ??= false;
        $validated['is_active'] ??= true;
        $validated['status'] ??= 'active';

        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $isFirst = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'is_primary' => $isFirst,
                    'sort_order' => $isFirst ? 0 : 1,
                ]);

                $isFirst = false;
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::active()->ordered()->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'name'             => ['required', 'string', 'max:255'],
            'slug'             => ['required', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description'      => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price'            => ['required', 'numeric', 'min:0'],
            'compare_price'    => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'quantity'         => ['required', 'integer', 'min:0'],
            'sku'              => ['nullable', 'string', 'max:100', 'unique:products,sku,' . $product->id],
            'barcode'          => ['nullable', 'string', 'max:100'],
            'is_featured'      => ['boolean'],
            'is_active'        => ['boolean'],
            'status'           => ['nullable', 'string', 'max:50'],
            'images'           => ['nullable', 'array'],
            'images.*'         => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $validated['is_featured'] ??= false;
        $validated['is_active'] ??= true;

        $product->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $maxSort = $product->images()->max('sort_order') ?? 0;

            foreach ($request->file('images') as $image) {
                $maxSort++;
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => $path,
                    'is_primary' => false,
                    'sort_order' => $maxSort,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product (soft delete).
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete(); // Soft delete

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete a specific product image.
     */
    public function destroyImage(ProductImage $image): RedirectResponse
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
