@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-rose-900 dark:text-white" data-i18n="admin.dashboard.title">Dashboard</h2>
        <p class="text-rose-500 text-sm mt-1 dark:text-rose-400" data-i18n="admin.dashboard.subtitle">Overview of your skincare store</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
            <p class="text-sm text-rose-500 font-medium dark:text-rose-400" data-i18n="admin.dashboard.total_products">Total Products</p>
            <p class="text-3xl font-bold text-rose-900 mt-1 dark:text-white">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
            <p class="text-sm text-rose-500 font-medium dark:text-rose-400" data-i18n="admin.dashboard.total_orders">Total Orders</p>
            <p class="text-3xl font-bold text-rose-900 mt-1 dark:text-white">{{ number_format($totalOrders) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
            <p class="text-sm text-rose-500 font-medium dark:text-rose-400" data-i18n="admin.dashboard.total_revenue">Total Revenue</p>
            <p class="text-3xl font-bold text-rose-900 mt-1 dark:text-white">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
            <p class="text-sm text-rose-500 font-medium dark:text-rose-400" data-i18n="admin.dashboard.customers">Customers</p>
            <p class="text-3xl font-bold text-rose-900 mt-1 dark:text-white">{{ number_format($totalCustomers) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="bg-white rounded-xl border border-rose-100 dark:bg-gray-900 dark:border-rose-900/30">
            <div class="px-6 py-4 border-b border-rose-100 dark:border-gray-800">
                <h3 class="font-semibold text-rose-900 dark:text-white" data-i18n="admin.dashboard.recent_orders">Recent Orders</h3>
            </div>
            <div class="p-6">
                @if ($recentOrders->count())
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-rose-500 dark:text-rose-400">
                                <th class="pb-3 font-medium" data-i18n="admin.orders.order">Order #</th>
                                <th class="pb-3 font-medium" data-i18n="admin.orders.customer">Customer</th>
                                <th class="pb-3 font-medium" data-i18n="admin.orders.total">Total</th>
                                <th class="pb-3 font-medium" data-i18n="admin.orders.status">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr class="border-t border-rose-100 dark:border-gray-800">
                                    <td class="py-2.5 font-medium text-rose-900 dark:text-white">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:underline hover:text-rose-600 dark:hover:text-rose-400">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="py-2.5 text-rose-700 dark:text-gray-300">{{ $order->user->name }}</td>
                                    <td class="py-2.5 text-rose-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                                    <td class="py-2.5">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                            {{ $order->status === 'shipped' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-rose-500 text-sm dark:text-rose-400" data-i18n="admin.dashboard.no_orders">No orders yet.</p>
                @endif
            </div>
        </div>

        {{-- Low Stock Products --}}
        <div class="bg-white rounded-xl border border-rose-100 dark:bg-gray-900 dark:border-rose-900/30">
            <div class="px-6 py-4 border-b border-rose-100 dark:border-gray-800">
                <h3 class="font-semibold text-rose-900 dark:text-white" data-i18n="admin.dashboard.low_stock">Low Stock Products</h3>
            </div>
            <div class="p-6">
                @if ($lowStockProducts->count())
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-rose-500 dark:text-rose-400">
                                <th class="pb-3 font-medium" data-i18n="admin.products.name">Product</th>
                                <th class="pb-3 font-medium" data-i18n="admin.products.stock">Qty</th>
                                <th class="pb-3 font-medium" data-i18n="admin.products.price">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStockProducts as $product)
                                <tr class="border-t border-rose-100 dark:border-gray-800">
                                    <td class="py-2.5 font-medium text-rose-900 dark:text-white">{{ $product->name }}</td>
                                    <td class="py-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $product->quantity <= 5 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 text-rose-700 dark:text-gray-300">${{ number_format($product->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-rose-500 text-sm dark:text-rose-400" data-i18n="admin.dashboard.all_stocked">All products are well-stocked.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
