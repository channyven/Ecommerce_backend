@extends('admin.layouts.app')

@section('title', $user->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.customers.back">&larr; Back to Customers</a>
        <h2 class="text-2xl font-bold text-rose-900 mt-2 dark:text-white">{{ $user->name }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                <h3 class="font-semibold text-rose-900 mb-3 dark:text-white" data-i18n="admin.customers.info">Customer Info</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-rose-500 dark:text-rose-400" data-i18n="admin.customers.email">Email</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-rose-500 dark:text-rose-400" data-i18n="admin.customers.phone">Phone</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ $user->phone ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-rose-500 dark:text-rose-400" data-i18n="admin.customers.status">Status</span>
                        <span class="font-medium text-rose-900 dark:text-white capitalize">{{ $user->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-rose-500 dark:text-rose-400" data-i18n="admin.customers.joined">Joined</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </dl>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                <h3 class="font-semibold text-rose-900 mb-4 dark:text-white" data-i18n="admin.customers.recent_orders">Recent Orders</h3>
                @if ($user->orders->count() > 0)
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-rose-500 border-b border-rose-100 dark:text-rose-400 dark:border-gray-800">
                                <th class="pb-3 font-medium" data-i18n="admin.orders.order">Order #</th>
                                <th class="pb-3 font-medium text-right" data-i18n="admin.orders.total">Total</th>
                                <th class="pb-3 font-medium text-center" data-i18n="admin.orders.status">Status</th>
                                <th class="pb-3 font-medium text-left" data-i18n="admin.orders.date">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                            @foreach ($user->orders as $order)
                                <tr>
                                    <td class="py-3">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-rose-900 font-medium hover:text-rose-600 hover:underline dark:text-white dark:hover:text-rose-400">{{ $order->order_number }}</a>
                                    </td>
                                    <td class="py-3 text-right text-rose-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                                    <td class="py-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-rose-700 dark:text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-rose-500 text-sm dark:text-rose-400" data-i18n="admin.customers.no_orders">This customer hasn't placed any orders yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
