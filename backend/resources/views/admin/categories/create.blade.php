@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.categories.back">&larr; Back to Categories</a>
        <h2 class="text-2xl font-bold text-rose-900 mt-2 dark:text-white" data-i18n="admin.categories.create">Create Category</h2>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 p-6 max-w-2xl dark:bg-gray-900 dark:border-rose-900/30">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.categories.name_label">Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.categories.slug">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="Leave blank to auto-generate"
                       class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.categories.description">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="parent_id" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.categories.parent_label">Parent Category</label>
                <select id="parent_id" name="parent_id"
                        class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                    <option value="" data-i18n="admin.categories.no_parent">— No Parent (Top Level) —</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.categories.sort_order">Sort Order</label>
                    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>
                <div class="flex items-center pt-6">
                    <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-rose-300 text-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:focus:ring-rose-400">
                    <label for="is_active" class="ml-2 text-sm text-rose-600 dark:text-rose-400" data-i18n="admin.categories.active_label">Active</label>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-rose-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-rose-600 transition shadow-sm shadow-rose-200 dark:shadow-none dark:hover:bg-rose-700" data-i18n="admin.categories.submit_create">
                    Create Category
                </button>
            </div>
        </form>
    </div>
@endsection
