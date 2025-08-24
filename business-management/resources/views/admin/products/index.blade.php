@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->available_qty < 10)
                                            <span class="badge bg-warning text-dark ms-2">Low Stock</span>
                                        @endif
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
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
</div>
@endsection
