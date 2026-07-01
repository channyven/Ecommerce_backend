<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with key metrics.
     */
    public function index(): View
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total');
        $totalCustomers = User::where('is_admin', false)->count();
        $recentOrders   = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        $lowStockProducts = Product::where('quantity', '<', 10)
            ->where('is_active', true)
            ->orderBy('quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
