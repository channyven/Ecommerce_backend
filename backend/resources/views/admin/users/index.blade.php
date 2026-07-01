@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-rose-900 dark:text-white" data-i18n="admin.customers.title">Customers</h2>
        <p class="text-rose-500 text-sm mt-1 dark:text-rose-400" data-i18n="admin.customers.subtitle">View registered customers</p>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 overflow-hidden dark:bg-gray-900 dark:border-rose-900/30">
        <table class="w-full text-sm">
            <thead class="bg-rose-50 border-b border-rose-100 dark:bg-gray-800/50 dark:border-gray-800">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.name">Name</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.email">Email</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.phone">Phone</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.orders">Orders</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.joined">Joined</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.customers.actions">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                @foreach ($users as $user)
                    <tr class="hover:bg-rose-50/50 transition dark:hover:bg-gray-800/30">
                        <td class="px-6 py-4 font-medium text-rose-900 dark:text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $user->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-center text-rose-700 dark:text-gray-300">{{ $user->orders_count }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-rose-600 hover:text-rose-800 font-medium text-sm dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.customers.view">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($users->isEmpty())
            <div class="text-center py-12 text-rose-500 dark:text-gray-400" data-i18n="admin.customers.none">No customers registered yet.</div>
        @endif
    </div>
    <div class="mt-6 dark:text-gray-300">
        {{ $users->links() }}
    </div>
@endsection
