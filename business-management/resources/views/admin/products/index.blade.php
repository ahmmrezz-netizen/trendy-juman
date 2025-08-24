@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-box me-2"></i>Products Management</h2>
        <p class="text-muted mb-0">Manage your product inventory and stock levels</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="exportProductsToCSV()">
            <i class="fas fa-file-csv me-1"></i>Export CSV
        </button>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add Product
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Product List</h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="productsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Added By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="rounded" 
                                     style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <div class="text-muted small">{{ Str::limit($product->description, 50) }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $product->category ?? 'General' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $product->size }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2" 
                                     style="width: 16px; height: 16px; background-color: {{ $product->color }}; border: 1px solid #dee2e6;"></div>
                                <span class="small">{{ $product->color }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">${{ number_format($product->price, 2) }}</div>
                            @if($product->discount_price)
                                <div class="text-muted small text-decoration-line-through">${{ number_format($product->discount_price, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <strong>{{ $product->available_qty }}</strong>
                                </div>
                                @if($product->available_qty <= 10)
                                    <span class="badge bg-warning">Low</span>
                                @elseif($product->available_qty == 0)
                                    <span class="badge bg-danger">Out</span>
                                @else
                                    <span class="badge bg-success">In Stock</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 24px; height: 24px;">
                                    <span class="text-white small fw-bold" style="font-size: 10px;">
                                        {{ $product->user ? strtoupper(substr($product->user->name, 0, 1)) : '?' }}
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-bold small">{{ $product->user ? $product->user->name : 'Unknown' }}</div>
                                    <div class="text-muted small">{{ $product->user ? $product->user->email : 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($product->available_qty == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->available_qty <= 10)
                                <span class="badge bg-warning">Low Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit Product">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#productsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[1, 'asc']], // Sort by name column
        columnDefs: [
            {
                targets: [0, 8, 9], // Image, Status, Actions columns
                orderable: false,
                searchable: false
            }
        ],
        language: {
            search: "Search products:",
            lengthMenu: "Show _MENU_ products per page",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        initComplete: function() {
            // Add custom search functionality
            $('#productSearch').on('keyup', function() {
                $('#productsTable').DataTable().search(this.value).draw();
            });
        }
    });
});

function exportProductsToCSV() {
    const table = $('#productsTable').DataTable();
    const data = table.data().toArray();
    
    let csv = 'Name,Category,Size,Color,Price,Stock,Status\n';
    
    data.forEach(function(row) {
        const name = row[1].replace(/<[^>]*>/g, '').trim();
        const category = row[2].replace(/<[^>]*>/g, '').trim();
        const size = row[3].replace(/<[^>]*>/g, '').trim();
        const color = row[4].replace(/<[^>]*>/g, '').trim();
        const price = row[5].replace(/<[^>]*>/g, '').trim();
        const stock = row[6].replace(/<[^>]*>/g, '').trim();
        const status = row[7].replace(/<[^>]*>/g, '').trim();
        
        csv += `"${name}","${category}","${size}","${color}","${price}","${stock}","${status}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'products_export.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endpush
@endsection
