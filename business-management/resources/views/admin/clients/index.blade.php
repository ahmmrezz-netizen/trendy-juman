@extends('admin.layouts.app')

@section('title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-users me-2"></i>Clients Management</h2>
        <p class="text-muted mb-0">Manage your client database and customer relationships</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="exportClientsToCSV()">
            <i class="fas fa-file-csv me-1"></i>Export CSV
        </button>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add Client
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Client List</h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control" placeholder="Search clients..." id="clientSearch">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="clientsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total Orders</th>
                        <th>Last Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 48px; height: 48px;">
                                <span class="text-white fw-bold">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $client->name }}</div>
                                <div class="text-muted small">ID: #{{ $client->id }}</div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $client->email }}" class="text-decoration-none">
                                <i class="fas fa-envelope me-1 text-muted"></i>
                                {{ $client->email }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $client->phone }}" class="text-decoration-none">
                                <i class="fas fa-phone me-1 text-muted"></i>
                                {{ $client->phone }}
                            </a>
                        </td>
                        <td>
                            <div class="text-muted small">
                                {{ Str::limit($client->address, 50) }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <strong>{{ $client->purchases_count ?? 0 }}</strong>
                                </div>
                                <span class="badge bg-info">Orders</span>
                            </div>
                        </td>
                        <td>
                            @if($client->last_purchase_date)
                                <div class="text-muted small">
                                    {{ $client->last_purchase_date->format('M d, Y') }}
                                </div>
                                <div class="text-muted small">
                                    {{ $client->last_purchase_date->diffForHumans() }}
                                </div>
                            @else
                                <span class="text-muted small">No orders yet</span>
                            @endif
                        </td>
                        <td>
                            @if($client->purchases_count > 0)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">New</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.clients.show', $client) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.clients.edit', $client) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit Client">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this client?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete Client">
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
    $('#clientsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[1, 'asc']], // Sort by name column
        columnDefs: [
            {
                targets: [0, 7, 8], // Avatar, Status, Actions columns
                orderable: false,
                searchable: false
            }
        ],
        language: {
            search: "Search clients:",
            lengthMenu: "Show _MENU_ clients per page",
            info: "Showing _START_ to _END_ of _TOTAL_ clients",
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
            $('#clientSearch').on('keyup', function() {
                $('#clientsTable').DataTable().search(this.value).draw();
            });
        }
    });
});

function exportClientsToCSV() {
    const table = $('#clientsTable').DataTable();
    const data = table.data().toArray();
    
    let csv = 'Name,Email,Phone,Address,Total Orders,Last Order,Status\n';
    
    data.forEach(function(row) {
        const name = row[1].replace(/<[^>]*>/g, '').trim();
        const email = row[2].replace(/<[^>]*>/g, '').trim();
        const phone = row[3].replace(/<[^>]*>/g, '').trim();
        const address = row[4].replace(/<[^>]*>/g, '').trim();
        const orders = row[5].replace(/<[^>]*>/g, '').trim();
        const lastOrder = row[6].replace(/<[^>]*>/g, '').trim();
        const status = row[7].replace(/<[^>]*>/g, '').trim();
        
        csv += `"${name}","${email}","${phone}","${address}","${orders}","${lastOrder}","${status}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'clients_export.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endpush
@endsection
