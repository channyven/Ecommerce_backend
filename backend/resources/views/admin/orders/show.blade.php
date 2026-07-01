@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300" data-i18n="admin.orders.back">&larr; Back to Orders</a>
        <h2 class="text-2xl font-bold text-rose-900 mt-2 dark:text-white">Order #{{ $order->order_number }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Order Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                <h3 class="font-semibold text-rose-900 mb-4 dark:text-white" data-i18n="admin.orders.items">Order Items</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-rose-500 border-b border-rose-100 dark:text-rose-400 dark:border-gray-800">
                            <th class="pb-3 font-medium" data-i18n="admin.orders.product">Product</th>
                            <th class="pb-3 font-medium text-right" data-i18n="admin.orders.price">Price</th>
                            <th class="pb-3 font-medium text-center" data-i18n="admin.orders.qty">Qty</th>
                            <th class="pb-3 font-medium text-right" data-i18n="admin.orders.line_total">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-100 dark:divide-gray-800">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="py-3 text-rose-900 dark:text-white">{{ $item->product_name }}</td>
                                <td class="py-3 text-right text-rose-700 dark:text-gray-300">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-3 text-center text-rose-700 dark:text-gray-300">{{ $item->quantity }}</td>
                                <td class="py-3 text-right text-rose-900 dark:text-white font-medium">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" class="pt-3 text-right text-rose-500 dark:text-rose-400" data-i18n="admin.orders.subtotal">Subtotal</td><td class="pt-3 text-right dark:text-gray-100">${{ number_format($order->subtotal, 2) }}</td></tr>
                        @if ($order->shipping_amount > 0)
                            <tr><td colspan="3" class="text-right text-rose-500 dark:text-rose-400" data-i18n="admin.orders.shipping">Shipping</td><td class="text-right dark:text-gray-100">${{ number_format($order->shipping_amount, 2) }}</td></tr>
                        @endif
                        @if ($order->tax_amount > 0)
                            <tr><td colspan="3" class="text-right text-rose-500 dark:text-rose-400" data-i18n="admin.orders.tax">Tax</td><td class="text-right dark:text-gray-100">${{ number_format($order->tax_amount, 2) }}</td></tr>
                        @endif
                        @if ($order->discount_amount > 0)
                            <tr><td colspan="3" class="text-right text-green-600 dark:text-green-400" data-i18n="admin.orders.discount">Discount</td><td class="text-right text-green-600 dark:text-green-400">-${{ number_format($order->discount_amount, 2) }}</td></tr>
                        @endif
                        <tr class="border-t border-rose-100 dark:border-gray-800">
                            <td colspan="3" class="pt-3 text-right font-semibold text-rose-900 dark:text-white" data-i18n="admin.orders.grand_total">Total</td>
                            <td class="pt-3 text-right font-bold text-rose-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($order->notes)
                <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                    <h3 class="font-semibold text-rose-900 mb-2 dark:text-white" data-i18n="admin.orders.notes">Order Notes</h3>
                    <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                <h3 class="font-semibold text-rose-900 mb-3 dark:text-white" data-i18n="admin.orders.summary">Order Summary</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-rose-500 dark:text-rose-400" data-i18n="admin.orders.status">Status</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="flex justify-between"><span class="text-rose-500 dark:text-rose-400" data-i18n="admin.orders.payment_status">Payment</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    @if ($order->payment_method)
                        <div class="flex justify-between"><span class="text-rose-500 dark:text-rose-400" data-i18n="admin.orders.method">Method</span>
                            <span class="font-medium text-rose-900 dark:text-white">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                    @endif
                    @if ($order->coupon)
                        <div class="flex justify-between"><span class="text-rose-500 dark:text-rose-400" data-i18n="admin.orders.coupon">Coupon</span>
                            <span class="font-medium text-rose-900 dark:text-white">{{ $order->coupon->code }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between"><span class="text-rose-500 dark:text-rose-400" data-i18n="admin.orders.date_label">Date</span>
                        <span class="font-medium text-rose-900 dark:text-white">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                <h3 class="font-semibold text-rose-900 mb-3 dark:text-white" data-i18n="admin.orders.customer_info">Customer</h3>
                <p class="text-sm font-medium text-rose-900 dark:text-white">{{ $order->user->name }}</p>
                <p class="text-sm text-rose-500 dark:text-rose-400">{{ $order->user->email }}</p>
            </div>

            @if ($order->shippingAddress)
                <div class="bg-white rounded-xl border border-rose-100 p-6 dark:bg-gray-900 dark:border-rose-900/30">
                    <h3 class="font-semibold text-rose-900 mb-3 dark:text-white" data-i18n="admin.orders.shipping_address">Shipping Address</h3>
                    <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->shippingAddress->full_name }}</p>
                    <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->shippingAddress->address_line1 }}</p>
                    @if ($order->shippingAddress->address_line2)
                        <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->shippingAddress->address_line2 }}</p>
                    @endif
                    <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</p>
                    <p class="text-sm text-rose-700 dark:text-gray-300">{{ $order->shippingAddress->country }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
