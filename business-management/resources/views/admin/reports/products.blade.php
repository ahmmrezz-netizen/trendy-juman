@extends('admin.layouts.app')

@section('title', 'Products Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products Report</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
            <a href="{{ route('admin.reports.export-products') }}" class="btn btn-success">
                <i class="bi bi-download"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                In Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inStock }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Low Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStock }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Out of Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $outOfStock }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detailed Products Report</h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Available Qty</th>
                                <th>Total Sold</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                    </td>
                                    <td>{{ $product->size }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->color }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->available_qty > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->available_qty }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $product->total_sold }}</span>
                                    </td>
                                    <td>
                                        @if($product->available_qty == 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->available_qty < 10)
                                            <span class="badge bg-warning text-dark">Low Stock</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-box display-1 text-muted"></i>
                    <h5 class="text-muted mt-3">No products found</h5>
                    <p class="text-muted">Start by adding your first product.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
        </div>
        <div class="card-body">
            @if($topSelling->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Product</th>
                                <th>Total Sold</th>
                                <th>Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSelling as $index => $product)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $product->size }}, {{ $product->color }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $product->total_sold }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->available_qty > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->available_qty }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No products have been purchased yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
