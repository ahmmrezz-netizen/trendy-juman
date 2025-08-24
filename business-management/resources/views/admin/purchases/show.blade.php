@extends('admin.layouts.app')

@section('title', 'Purchase Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Purchase Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Purchases
            </a>
            <a href="{{ route('admin.purchases.edit', $purchase) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('admin.purchases.destroy', $purchase) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this purchase?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Purchase Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Purchase Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Purchase ID:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->id }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Purchase Date:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->purchase_date->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Quantity:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary">{{ $purchase->qty }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->updated_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client & Product Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Client & Product Details</h6>
                </div>
                <div class="card-body">
                    <h6>Client Information</h6>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{ route('admin.clients.show', $purchase->client) }}" 
                               class="text-decoration-none">
                                {{ $purchase->client->name }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->client->email }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $purchase->client->phone }}
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Product Information</h6>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="{{ route('admin.products.show', $purchase->product) }}" 
                               class="text-decoration-none">
                                {{ $purchase->product->name }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Size:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary">{{ $purchase->product->size }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Color:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary">{{ $purchase->product->color }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Current Stock:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge {{ $purchase->product->available_qty > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $purchase->product->available_qty }}
                            </span>
                        </div>
                    </div>
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
                                <i class="bi bi-cart-plus"></i> Record New Purchase
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.purchases.edit', $purchase) }}" class="btn btn-warning w-100">
                                <i class="bi bi-pencil"></i> Edit Purchase
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-list"></i> All Purchases
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
