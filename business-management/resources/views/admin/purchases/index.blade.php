@extends('admin.layouts.app')

@section('title', 'Purchases')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Purchases</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Record Purchase
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.purchases.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Search purchases..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Purchases</h6>
        </div>
        <div class="card-body">
            @if($purchases->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Purchase Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.clients.show', $purchase->client) }}" 
                                           class="text-decoration-none">
                                            <strong>{{ $purchase->client->name }}</strong>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $purchase->product) }}" 
                                           class="text-decoration-none">
                                            <strong>{{ $purchase->product->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $purchase->product->size }}, {{ $purchase->product->color }}
                                            </small>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $purchase->qty }}</span>
                                    </td>
                                    <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.purchases.show', $purchase) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.purchases.edit', $purchase) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.purchases.destroy', $purchase) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this purchase?')">
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
                    {{ $purchases->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-cart display-1 text-muted"></i>
                    <h5 class="text-muted mt-3">No purchases found</h5>
                    <p class="text-muted">Start by recording your first purchase.</p>
                    <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Record Purchase
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
