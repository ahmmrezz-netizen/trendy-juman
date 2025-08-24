<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Client;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get all admins who have added products
        $admins = User::whereHas('products')->get();
        
        // Filter products by admin if specified
        $productsQuery = Product::with('user');
        if ($request->filled('admin_id')) {
            $productsQuery->where('added_by', $request->admin_id);
        }
        
        // Regular users can only see their own products
        if (!auth()->user()->is_super_admin) {
            $productsQuery->where('added_by', auth()->id());
        }
        
        $products = $productsQuery->get();
        
        // Prepare chart data for admin inventory
        $chartData = $this->prepareAdminChartData($request->admin_id);
        
        $data = [
            'totalProducts' => Product::count(),
            'totalClients' => Client::count(),
            'totalOrders' => Purchase::count(),
            'totalSoldQty' => Purchase::sum('qty'),
            'lowStockCount' => Product::where('available_qty', '<', 10)->count(),
            'activeClients' => Client::whereHas('purchases')->count(),
            'topProducts' => Product::withCount('purchases')
                ->withSum('purchases', 'qty')
                ->orderBy('purchases_count', 'desc')
                ->take(5)
                ->get()
                ->map(function ($product) {
                    $product->total_sold = $product->purchases_sum_qty ?? 0;
                    return $product;
                }),
            'topClients' => Client::withCount('purchases')
                ->withSum('purchases', 'total_amount')
                ->orderBy('purchases_sum_total_amount', 'desc')
                ->take(5)
                ->get()
                ->map(function ($client) {
                    $client->total_spent = $client->purchases_sum_total_amount ?? 0;
                    $client->last_purchase_date = $client->purchases()->latest()->first()?->purchase_date;
                    return $client;
                }),
            'productReport' => $this->getProductReport(),
            'clientReport' => $this->getClientReport(),
            'purchaseReport' => $this->getPurchaseReport(),
            // Multi-admin inventory data
            'admins' => $admins,
            'products' => $products,
            'chartData' => $chartData,
            'selectedAdminId' => $request->admin_id
        ];
        
        return view('admin.reports.index', $data);
    }

    private function prepareAdminChartData($adminId = null)
    {
        $query = Product::with('user')
            ->selectRaw('added_by, SUM(available_qty) as total_qty, COUNT(*) as product_count')
            ->groupBy('added_by');
        
        if ($adminId) {
            $query->where('added_by', $adminId);
        }
        
        // Regular users can only see their own data
        if (!auth()->user()->is_super_admin) {
            $query->where('added_by', auth()->id());
        }
        
        $adminData = $query->get();
        
        $admins = [];
        $totals = [];
        
        foreach ($adminData as $data) {
            $user = User::find($data->added_by);
            if ($user) {
                $admins[] = $user->name;
                $totals[] = $data->total_qty;
            }
        }
        
        return [
            'admins' => $admins,
            'totals' => $totals
        ];
    }

    public function products()
    {
        $products = Product::with('user')
            ->withCount('purchases')
            ->withSum('purchases', 'qty')
            ->get()
            ->map(function ($product) {
                $product->total_sold = $product->purchases_sum_qty ?? 0;
                return $product;
            });

        return view('admin.reports.products', compact('products'));
    }

    public function clients()
    {
        $clients = Client::withCount('purchases')
            ->withSum('purchases', 'qty')
            ->get()
            ->map(function ($client) {
                $client->total_purchases = $client->purchases_sum_qty ?? 0;
                return $client;
            });

        return view('admin.reports.clients', compact('clients'));
    }

    public function exportProducts()
    {
        $products = Product::with('user')
            ->withCount('purchases')
            ->withSum('purchases', 'qty')
            ->get()
            ->map(function ($product) {
                return [
                    'Name' => $product->name,
                    'Size' => $product->size,
                    'Color' => $product->color,
                    'Available Qty' => $product->available_qty,
                    'Sold Qty' => $product->purchases_sum_qty ?? 0,
                    'Total Purchases' => $product->purchases_count,
                    'Added By' => $product->user ? $product->user->name : 'Unknown'
                ];
            });

        $filename = 'products_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($products->first()));
            
            foreach ($products as $product) {
                fputcsv($file, $product);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function getProductReport()
    {
        return [
            'total_products' => Product::count(),
            'low_stock' => Product::where('available_qty', '<', 10)->count(),
            'out_of_stock' => Product::where('available_qty', 0)->count(),
            'top_selling' => Product::withCount('purchases')
                ->orderBy('purchases_count', 'desc')
                ->take(5)
                ->get()
        ];
    }

    private function getClientReport()
    {
        return [
            'total_clients' => Client::count(),
            'active_clients' => Client::whereHas('purchases')->count(),
            'top_clients' => Client::withCount('purchases')
                ->withSum('purchases', 'qty')
                ->orderBy('purchases_sum_qty', 'desc')
                ->take(5)
                ->get()
        ];
    }

    private function getPurchaseReport()
    {
        return [
            'total_purchases' => Purchase::count(),
            'total_revenue' => Purchase::sum('qty'), // Simplified - in real app you'd have price
            'monthly_purchases' => Purchase::selectRaw('MONTH(purchase_date) as month, COUNT(*) as count')
                ->whereYear('purchase_date', date('Y'))
                ->groupBy('month')
                ->get()
        ];
    }
}
