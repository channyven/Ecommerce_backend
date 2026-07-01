@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-rose-900 dark:text-white" data-i18n="admin.categories.title">Categories</h2>
            <p class="text-rose-500 text-sm mt-1 dark:text-rose-400" data-i18n="admin.categories.subtitle">Manage your product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-rose-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-rose-600 transition shadow-sm shadow-rose-200 dark:shadow-none dark:hover:bg-rose-700" data-i18n="admin.categories.new">
            + New Category
        </a>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 overflow-hidden dark:bg-gray-900 dark:border-rose-900/30">
        <table class="w-full text-sm">
            <thead class="bg-rose-50 border-b border-rose-100 dark:bg-gray-800/50 dark:border-gray-800">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.name">Name</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.slug">Slug</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.parent">Parent</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.count">Products</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.active">Active</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.categories.actions">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                @foreach ($categories as $category)
                    <tr class="hover:bg-rose-50/50 transition dark:hover:bg-gray-800/30">
                        <td class="px-6 py-4 font-medium text-rose-900 dark:text-white">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $category->parent?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-center text-rose-700 dark:text-gray-300">{{ $category->products_count }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($category->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300" data-i18n="admin.yes">Yes</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300" data-i18n="admin.no">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-rose-600 hover:text-rose-800 font-medium text-sm dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.categories.edit">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline ml-3">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Delete this category?')" data-i18n="admin.categories.delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($categories->isEmpty())
            <div class="text-center py-12 text-rose-500 dark:text-gray-400" data-i18n="admin.categories.none">No categories found. Create your first category!</div>
        @endif
    </div>
    <div class="mt-6 dark:text-gray-300">
        {{ $categories->links() }}
    </div>
@endsection
