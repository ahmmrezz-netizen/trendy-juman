<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Client;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalProducts' => Product::count(),
            'totalClients' => Client::count(),
            'totalStockQty' => Product::sum('available_qty'),
            'totalSoldQty' => Purchase::sum('qty'),
            'recentPurchases' => Purchase::with(['client', 'product'])
                ->latest()
                ->take(5)
                ->get(),
            'lowStockProducts' => Product::where('available_qty', '<', 10)
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', $data);
    }
}
