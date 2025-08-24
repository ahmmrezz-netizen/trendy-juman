@extends('admin.layouts.app')

@section('title', 'Client Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Client Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Clients
            </a>
            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this client?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Client Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Client Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Client ID:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $client->id }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $client->name }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-sm-8">
                            <a href="tel:{{ $client->phone }}">{{ $client->phone }}</a>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Total Purchases:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-info">{{ $client->total_purchases }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $client->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $client->updated_at->format('M d, Y H:i') }}
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
                    @if($client->purchases->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->purchase_date->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.products.show', $purchase->product) }}" 
                                                   class="text-decoration-none">
                                                    {{ $purchase->product->name }}
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $purchase->product->size }}, {{ $purchase->product->color }}
                                                    </small>
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
                        <p class="text-muted text-center py-3">No purchase history for this client.</p>
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
                            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning w-100">
                                <i class="bi bi-pencil"></i> Edit Client
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-list"></i> All Clients
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
