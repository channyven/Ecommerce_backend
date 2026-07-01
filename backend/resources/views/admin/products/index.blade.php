@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-rose-900 dark:text-white" data-i18n="admin.products.title">Products</h2>
            <p class="text-rose-500 text-sm mt-1 dark:text-rose-400" data-i18n="admin.products.subtitle">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-rose-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-rose-600 transition shadow-sm shadow-rose-200 dark:shadow-none dark:hover:bg-rose-700" data-i18n="admin.products.new">
            + New Product
        </a>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 overflow-hidden dark:bg-gray-900 dark:border-rose-900/30">
        <table class="w-full text-sm">
            <thead class="bg-rose-50 border-b border-rose-100 dark:bg-gray-800/50 dark:border-gray-800">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.name">Product</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.category">Category</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.price">Price</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.stock">Stock</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.status">Status</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.products.actions">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                @foreach ($products as $product)
                    <tr class="hover:bg-rose-50/50 transition dark:hover:bg-gray-800/30">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($product->primaryImage)
                                    @php $imgPath = $product->primaryImage->path; @endphp
                                    <img src="{{ str_starts_with($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" alt="" class="w-10 h-10 rounded-lg object-cover border border-rose-200 dark:border-gray-700">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-rose-100 border border-rose-200 flex items-center justify-center text-rose-400 text-xs dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">N/A</div>
                                @endif
                                <div>
                                    <p class="font-medium text-rose-900 dark:text-white">{{ $product->name }}</p>
                                    <p class="text-rose-400 text-xs dark:text-gray-500">{{ $product->sku ?? 'No SKU' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-right text-rose-900 dark:text-white">
                            ${{ number_format($product->price, 2) }}
                            @if ($product->has_discount)
                                <span class="text-xs text-red-500 ml-1">-{{ $product->discount_percent }}%</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $product->quantity > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                {{ $product->quantity <= 10 && $product->quantity > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                {{ $product->quantity == 0 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($product->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-rose-600 hover:text-rose-800 font-medium text-sm dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.products.edit">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline ml-3">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Delete this product?')" data-i18n="admin.products.delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($products->isEmpty())
            <div class="text-center py-12 text-rose-500 dark:text-gray-400" data-i18n="admin.products.none">No products found. Create your first product!</div>
        @endif
    </div>
    <div class="mt-6 dark:text-gray-300">
        {{ $products->links() }}
    </div>
@endsection
