@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Reports & Analytics</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.reports.export-products') }}" class="btn btn-success">
                <i class="bi bi-download"></i> Export Products
            </a>
        </div>
    </div>

    <!-- Report Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productReport['total_products'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box fa-2x text-gray-300"></i>
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
                                Low Stock Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productReport['low_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 card-stats">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Out of Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productReport['out_of_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
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
                                Active Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clientReport['active_clients'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row">
        <!-- Product Report -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Report</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.reports.products') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> View Detailed Report
                        </a>
                        <a href="{{ route('admin.reports.export-products') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                    </div>
                    
                    <h6>Top Selling Products</h6>
                    @if($productReport['top_selling']->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($productReport['top_selling'] as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $product->size }}, {{ $product->color }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $product->purchases_count }} purchases</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No products have been purchased yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Client Report -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Client Report</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.reports.clients') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> View Detailed Report
                        </a>
                    </div>
                    
                    <h6>Top Clients</h6>
                    @if($clientReport['top_clients']->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($clientReport['top_clients'] as $client)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $client->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $client->email }}</small>
                                    </div>
                                    <span class="badge bg-success">{{ $client->purchases_sum_qty ?? 0 }} items</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No clients have made purchases yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Report -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Purchase Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h4 class="text-primary">{{ $purchaseReport['total_purchases'] }}</h4>
                                <p class="text-muted">Total Purchases</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h4 class="text-success">{{ $purchaseReport['total_revenue'] }}</h4>
                                <p class="text-muted">Total Items Sold</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h4 class="text-info">{{ $clientReport['total_clients'] }}</h4>
                                <p class="text-muted">Total Clients</p>
                            </div>
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
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">
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
