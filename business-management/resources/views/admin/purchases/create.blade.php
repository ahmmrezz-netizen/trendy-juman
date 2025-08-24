@extends('admin.layouts.app')

@section('title', 'Record Purchase')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Record New Purchase</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Purchases
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Purchase Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.purchases.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="client_id" class="form-label">Client *</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" 
                                        id="client_id" name="client_id" required>
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" 
                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} ({{ $client->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Product *</label>
                                <select class="form-select @error('product_id') is-invalid @enderror" 
                                        id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-stock="{{ $product->available_qty }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ $product->size }}, {{ $product->color }}) - 
                                            Stock: {{ $product->available_qty }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="qty" class="form-label">Quantity *</label>
                                <input type="number" class="form-control @error('qty') is-invalid @enderror" 
                                       id="qty" name="qty" value="{{ old('qty', 1) }}" 
                                       min="1" required>
                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Available stock: <span id="stock-display">-</span></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="purchase_date" class="form-label">Purchase Date *</label>
                                <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                       id="purchase_date" name="purchase_date" 
                                       value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary me-md-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Record Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const stockDisplay = document.getElementById('stock-display');
    
    function updateStockDisplay() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.stock) {
            stockDisplay.textContent = selectedOption.dataset.stock;
        } else {
            stockDisplay.textContent = '-';
        }
    }
    
    productSelect.addEventListener('change', updateStockDisplay);
    updateStockDisplay();
});
</script>
@endpush
@endsection
