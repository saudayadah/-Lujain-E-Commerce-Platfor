<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_products' => Product::count(),
            'low_stock_products' => Product::whereColumn('stock', '<=', 'low_stock_alert')->count(),
            'total_customers' => User::where(function($q) {
                $q->where('role', 'customer')->orWhereNull('role');
            })->orWhere('role', '!=', 'admin')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'low_stock_alert')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}

