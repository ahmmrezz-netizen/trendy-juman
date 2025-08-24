@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Stock Qty</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStockQty }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Sold Qty</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSoldQty }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Purchases</h6>
                </div>
                <div class="card-body">
                    @if($recentPurchases->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentPurchases as $purchase)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $purchase->client->name }}</strong> purchased 
                                        <strong>{{ $purchase->qty }}</strong> x {{ $purchase->product->name }}
                                    </div>
                                    <small class="text-muted">{{ $purchase->purchase_date->format('M d, Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No recent purchases.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Low Stock Products</h6>
                </div>
                <div class="card-body">
                    @if($lowStockProducts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($lowStockProducts as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $product->name }}</strong> ({{ $product->size }}, {{ $product->color }})
                                    </div>
                                    <span class="badge bg-warning text-dark">{{ $product->available_qty }} left</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">All products have sufficient stock.</p>
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
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.clients.create') }}" class="btn btn-success w-100">
                                <i class="bi bi-person-plus"></i> Add Client
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.purchases.create') }}" class="btn btn-info w-100">
                                <i class="bi bi-cart-plus"></i> Record Purchase
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-warning w-100">
                                <i class="bi bi-graph-up"></i> View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
