@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Product Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Product Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Product ID:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $product->id }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $product->name }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Size:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary">{{ $product->size }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Color:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary">{{ $product->color }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Available Quantity:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge {{ $product->available_qty > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->available_qty }}
                            </span>
                            @if($product->available_qty < 10)
                                <span class="badge bg-warning text-dark ms-2">Low Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Total Sold:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-info">{{ $product->total_sold }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $product->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $product->updated_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase History -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Purchase History</h6>
                </div>
                <div class="card-body">
                    @if($product->purchases->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.clients.show', $purchase->client) }}" 
                                                   class="text-decoration-none">
                                                    {{ $purchase->client->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $purchase->qty }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No purchase history for this product.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.purchases.create') }}" class="btn btn-info w-100">
                                <i class="bi bi-cart-plus"></i> Record Purchase
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning w-100">
                                <i class="bi bi-pencil"></i> Edit Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-list"></i> All Products
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-100">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
