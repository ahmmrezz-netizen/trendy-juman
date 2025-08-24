@extends('admin.layouts.app')

@section('title', 'Purchases')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-shopping-cart me-2"></i>Purchases Management</h2>
        <p class="text-muted mb-0">Track and manage all customer orders and transactions</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="exportPurchasesToCSV()">
            <i class="fas fa-file-csv me-1"></i>Export CSV
        </button>
        <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add Purchase
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Purchase List</h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control" placeholder="Search purchases..." id="purchaseSearch">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="purchasesTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Amount</th>
                        <th>Purchase Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>
                            <div class="fw-bold text-primary">#{{ $purchase->id }}</div>
                            <div class="text-muted small">{{ $purchase->created_at->format('M d, Y H:i') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 32px; height: 32px;">
                                    <span class="text-white small fw-bold">{{ strtoupper(substr($purchase->client->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $purchase->client->name }}</div>
                                    <div class="text-muted small">{{ $purchase->client->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($purchase->product->image)
                                    <img src="{{ asset('storage/' . $purchase->product->image) }}" 
                                         alt="{{ $purchase->product->name }}" 
                                         class="me-2" 
                                         style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                         style="width: 32px; height: 32px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $purchase->product->name }}</div>
                                    <div class="text-muted small">{{ $purchase->product->size }} | {{ $purchase->product->color }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info me-2">{{ $purchase->qty }}</span>
                                <span class="text-muted small">units</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">${{ number_format($purchase->unit_price, 2) }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-success">${{ number_format($purchase->total_amount, 2) }}</div>
                        </td>
                        <td>
                            <div class="text-muted small">
                                {{ $purchase->purchase_date->format('M d, Y') }}
                            </div>
                            <div class="text-muted small">
                                {{ $purchase->purchase_date->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success">Completed</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.purchases.show', $purchase) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.purchases.edit', $purchase) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit Purchase">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.purchases.destroy', $purchase) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this purchase?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete Purchase">
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
    $('#purchasesTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[6, 'desc']], // Sort by purchase date column (descending)
        columnDefs: [
            {
                targets: [7, 8], // Status, Actions columns
                orderable: false,
                searchable: false
            }
        ],
        language: {
            search: "Search purchases:",
            lengthMenu: "Show _MENU_ purchases per page",
            info: "Showing _START_ to _END_ of _TOTAL_ purchases",
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
            $('#purchaseSearch').on('keyup', function() {
                $('#purchasesTable').DataTable().search(this.value).draw();
            });
        }
    });
});

function exportPurchasesToCSV() {
    const table = $('#purchasesTable').DataTable();
    const data = table.data().toArray();
    
    let csv = 'Order ID,Client,Product,Quantity,Unit Price,Total Amount,Purchase Date,Status\n';
    
    data.forEach(function(row) {
        const orderId = row[0].replace(/<[^>]*>/g, '').trim();
        const client = row[1].replace(/<[^>]*>/g, '').trim();
        const product = row[2].replace(/<[^>]*>/g, '').trim();
        const quantity = row[3].replace(/<[^>]*>/g, '').trim();
        const unitPrice = row[4].replace(/<[^>]*>/g, '').trim();
        const totalAmount = row[5].replace(/<[^>]*>/g, '').trim();
        const purchaseDate = row[6].replace(/<[^>]*>/g, '').trim();
        const status = row[7].replace(/<[^>]*>/g, '').trim();
        
        csv += `"${orderId}","${client}","${product}","${quantity}","${unitPrice}","${totalAmount}","${purchaseDate}","${status}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'purchases_export.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endpush
@endsection
