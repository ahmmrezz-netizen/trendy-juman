<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Client;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'productReport' => $this->getProductReport(),
            'clientReport' => $this->getClientReport(),
            'purchaseReport' => $this->getPurchaseReport()
        ];
        
        return view('admin.reports.index', $data);
    }

    public function products()
    {
        $products = Product::withCount('purchases')
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
        $products = Product::withCount('purchases')
            ->withSum('purchases', 'qty')
            ->get()
            ->map(function ($product) {
                return [
                    'Name' => $product->name,
                    'Size' => $product->size,
                    'Color' => $product->color,
                    'Available Qty' => $product->available_qty,
                    'Sold Qty' => $product->purchases_sum_qty ?? 0,
                    'Total Purchases' => $product->purchases_count
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
