<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('size', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%");
            });
        }
        
        $products = $query->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load('purchases.client');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
