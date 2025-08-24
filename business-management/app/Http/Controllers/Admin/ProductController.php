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
        $query = Product::with('user');
        
        // Filter by admin if specified
        if ($request->filled('admin_id')) {
            $query->where('added_by', $request->admin_id);
        }
        
        // Regular users can only see their own products
        if (!auth()->user()->is_super_admin) {
            $query->where('added_by', auth()->id());
        }
        
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
        $data = $request->validated();
        $data['added_by'] = auth()->id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        Product::create($data);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        // Check if user can view this product
        if (!auth()->user()->is_super_admin && $product->added_by !== auth()->id()) {
            abort(403, 'Unauthorized access to this product.');
        }
        
        $product->load('purchases.client');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Check if user can edit this product
        if (!auth()->user()->is_super_admin && $product->added_by !== auth()->id()) {
            abort(403, 'Unauthorized access to edit this product.');
        }
        
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        // Check if user can update this product
        if (!auth()->user()->is_super_admin && $product->added_by !== auth()->id()) {
            abort(403, 'Unauthorized access to update this product.');
        }
        
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        $product->update($data);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Check if user can delete this product
        if (!auth()->user()->is_super_admin && $product->added_by !== auth()->id()) {
            abort(403, 'Unauthorized access to delete this product.');
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $path = $file->store('products', 'public');
            return response()->json(['filename' => $path]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
