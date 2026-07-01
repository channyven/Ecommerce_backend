@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.products.back">&larr; Back to Products</a>
        <h2 class="text-2xl font-bold text-rose-900 mt-2 dark:text-white"><span data-i18n="admin.products.edit_title">Edit</span>: {{ $product->name }}</h2>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 p-6 max-w-3xl dark:bg-gray-900 dark:border-rose-900/30">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.name_label">Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.category">Category *</label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                        <option value="">Select...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.slug">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                       class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
            </div>

            <div>
                <label for="short_description" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.short_desc">Short Description</label>
                <input id="short_description" type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="500"
                       class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.full_desc">Full Description</label>
                <textarea id="description" name="description" rows="5"
                          class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.price_label">Price * ($)</label>
                    <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
                <div>
                    <label for="compare_price" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.compare_price">Compare Price ($)</label>
                    <input id="compare_price" type="number" step="0.01" min="0" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}"
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.quantity">Quantity *</label>
                    <input id="quantity" type="number" min="0" name="quantity" value="{{ old('quantity', $product->quantity) }}" required
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
                <div>
                    <label for="sku" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.sku">SKU</label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
            </div>

            {{-- Existing Images --}}
            @if ($product->images->count() > 0)
                <div>
                    <p class="block text-sm font-medium text-rose-700 mb-2 dark:text-rose-300" data-i18n="admin.products.current_images">Current Images</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($product->images as $img)
                            <div class="relative group">
                                <img src="{{ str_starts_with($img->path, 'http') ? $img->path : asset('storage/' . $img->path) }}" alt="" class="w-20 h-20 rounded-lg object-cover border border-rose-200 dark:border-gray-700 dark:bg-gray-800">
                                @if ($img->is_primary)
                                    <span class="absolute top-0 left-0 bg-rose-500 text-white text-xs px-1.5 py-0.5 rounded-tl-lg rounded-br-lg" data-i18n="admin.products.primary">Primary</span>
                                @endif
                                <a href="{{ route('admin.products.images.destroy', $img) }}"
                                   onclick="return confirm('Delete this image?')"
                                   class="absolute top-0 right-0 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-bl-lg opacity-0 group-hover:opacity-100 transition">
                                    &times;
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <label for="images" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.products.add_images">Add New Images</label>
                <input id="images" type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                       class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="rounded border-rose-300 text-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:focus:ring-rose-400">
                    <span class="ml-2 text-sm text-rose-600 dark:text-rose-400" data-i18n="admin.products.featured">Featured</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="rounded border-rose-300 text-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:focus:ring-rose-400">
                    <span class="ml-2 text-sm text-rose-600 dark:text-rose-400" data-i18n="admin.products.active">Active</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-rose-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-rose-600 transition shadow-sm shadow-rose-200 dark:shadow-none dark:hover:bg-rose-700" data-i18n="admin.products.submit_update">
                    Update Product
                </button>
            </div>
        </form>
    </div>
@endsection
