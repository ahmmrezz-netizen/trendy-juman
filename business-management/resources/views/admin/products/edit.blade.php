@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Product Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="size" class="form-label">Size *</label>
                                <select class="form-select @error('size') is-invalid @enderror" 
                                        id="size" name="size" required>
                                    <option value="">Select Size</option>
                                    <option value="XS" {{ old('size', $product->size) == 'XS' ? 'selected' : '' }}>XS</option>
                                    <option value="S" {{ old('size', $product->size) == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ old('size', $product->size) == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ old('size', $product->size) == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ old('size', $product->size) == 'XL' ? 'selected' : '' }}>XL</option>
                                    <option value="XXL" {{ old('size', $product->size) == 'XXL' ? 'selected' : '' }}>XXL</option>
                                </select>
                                @error('size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color *</label>
                                <select class="form-select @error('color') is-invalid @enderror" 
                                        id="color" name="color" required>
                                    <option value="">Select Color</option>
                                    <option value="Red" {{ old('color', $product->color) == 'Red' ? 'selected' : '' }}>Red</option>
                                    <option value="Blue" {{ old('color', $product->color) == 'Blue' ? 'selected' : '' }}>Blue</option>
                                    <option value="Green" {{ old('color', $product->color) == 'Green' ? 'selected' : '' }}>Green</option>
                                    <option value="Black" {{ old('color', $product->color) == 'Black' ? 'selected' : '' }}>Black</option>
                                    <option value="White" {{ old('color', $product->color) == 'White' ? 'selected' : '' }}>White</option>
                                    <option value="Yellow" {{ old('color', $product->color) == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                                    <option value="Purple" {{ old('color', $product->color) == 'Purple' ? 'selected' : '' }}>Purple</option>
                                    <option value="Orange" {{ old('color', $product->color) == 'Orange' ? 'selected' : '' }}>Orange</option>
                                    <option value="Pink" {{ old('color', $product->color) == 'Pink' ? 'selected' : '' }}>Pink</option>
                                    <option value="Brown" {{ old('color', $product->color) == 'Brown' ? 'selected' : '' }}>Brown</option>
                                    <option value="Gray" {{ old('color', $product->color) == 'Gray' ? 'selected' : '' }}>Gray</option>
                                </select>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="available_qty" class="form-label">Available Quantity *</label>
                                <input type="number" class="form-control @error('available_qty') is-invalid @enderror" 
                                       id="available_qty" name="available_qty" 
                                       value="{{ old('available_qty', $product->available_qty) }}" 
                                       min="0" required>
                                @error('available_qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-md-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
