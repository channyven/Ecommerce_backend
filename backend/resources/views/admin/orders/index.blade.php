@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-rose-900 dark:text-white" data-i18n="admin.orders.title">Orders</h2>
        <p class="text-rose-500 text-sm mt-1 dark:text-rose-400" data-i18n="admin.orders.subtitle">View and manage customer orders</p>
    </div>

    <div class="bg-white rounded-xl border border-rose-100 overflow-hidden dark:bg-gray-900 dark:border-rose-900/30">
        <table class="w-full text-sm">
            <thead class="bg-rose-50 border-b border-rose-100 dark:bg-gray-800/50 dark:border-gray-800">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.order">Order #</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.customer">Customer</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.total">Total</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.status">Status</th>
                    <th class="text-center px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.payment">Payment</th>
                    <th class="text-left px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.date">Date</th>
                    <th class="text-right px-6 py-3 font-medium text-rose-600 dark:text-rose-400" data-i18n="admin.orders.actions">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                @foreach ($orders as $order)
                    <tr class="hover:bg-rose-50/50 transition dark:hover:bg-gray-800/30">
                        <td class="px-6 py-4 font-medium text-rose-900 dark:text-white">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 text-right text-rose-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                {{ $order->status === 'processing' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                {{ $order->payment_status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                {{ $order->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-rose-700 dark:text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-rose-600 hover:text-rose-800 font-medium text-sm dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.orders.view">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($orders->isEmpty())
            <div class="text-center py-12 text-rose-500 dark:text-gray-400" data-i18n="admin.orders.none">No orders yet.</div>
        @endif
    </div>
    <div class="mt-6 dark:text-gray-300">
        {{ $orders->links() }}
    </div>
@endsection
