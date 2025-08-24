<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['client', 'product']);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        $purchases = $query->latest()->paginate(10);
        
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::where('available_qty', '>', 0)->get();
        
        return view('admin.purchases.create', compact('clients', 'products'));
    }

    public function store(PurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $purchase = Purchase::create($request->validated());
            
            // Reduce product stock
            $product = Product::find($request->product_id);
            $product->decrement('available_qty', $request->qty);
            
            DB::commit();
            
            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase recorded successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error recording purchase. Please try again.');
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['client', 'product']);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $clients = Client::all();
        $products = Product::all();
        
        return view('admin.purchases.edit', compact('purchase', 'clients', 'products'));
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        try {
            DB::beginTransaction();
            
            $oldQty = $purchase->qty;
            $newQty = $request->qty;
            
            // Restore old quantity to product stock
            $purchase->product->increment('available_qty', $oldQty);
            
            // Update purchase
            $purchase->update($request->validated());
            
            // Reduce new quantity from product stock
            $purchase->product->decrement('available_qty', $newQty);
            
            DB::commit();
            
            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating purchase. Please try again.');
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            DB::beginTransaction();
            
            // Restore quantity to product stock
            $purchase->product->increment('available_qty', $purchase->qty);
            
            $purchase->delete();
            
            DB::commit();
            
            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting purchase. Please try again.');
        }
    }
}
