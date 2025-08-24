@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-chart-bar me-2"></i>Analytics & Reports</h2>
        <p class="text-muted mb-0">Comprehensive business insights and performance metrics</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="exportReportToPDF()">
            <i class="fas fa-file-pdf me-1"></i>Export PDF
        </button>
        <button class="btn btn-outline-success" onclick="exportReportToExcel()">
            <i class="fas fa-file-excel me-1"></i>Export Excel
        </button>
    </div>
</div>

<!-- Multi-Admin Inventory Report -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Multi-Admin Inventory Report</h5>
                <div class="d-flex gap-2">
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="d-flex gap-2">
                        <select name="admin_id" class="form-select form-select-sm" style="width: 200px;" onchange="this.form.submit()">
                            <option value="">All Admins</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $selectedAdminId == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="chart-container">
                            <canvas id="adminInventoryChart"></canvas>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Admin</th>
                                        <th>Products</th>
                                        <th>Total Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chartData['admins'] as $index => $adminName)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 24px; height: 24px;">
                                                    <span class="text-white small fw-bold" style="font-size: 10px;">
                                                        {{ strtoupper(substr($adminName, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span class="fw-bold small">{{ $adminName }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $products->where('user.name', $adminName)->count() }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">{{ number_format($chartData['totals'][$index]) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sales Analytics</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print Chart</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesAnalyticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Product Categories</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print Chart</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="productCategoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Ownership Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Product Ownership Details</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportProductsToCSV()">
                        <i class="fas fa-file-csv me-1"></i>Export CSV
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye me-1"></i>View All Products
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Available Qty</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 32px; height: 32px;">
                                            <span class="text-white small fw-bold">
                                                {{ $product->user ? strtoupper(substr($product->user->name, 0, 1)) : '?' }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $product->user ? $product->user->name : 'Unknown' }}</div>
                                            <div class="text-muted small">{{ $product->user ? $product->user->email : 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="me-2" 
                                                 style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <div class="text-muted small">{{ Str::limit($product->description, 50) }}</div>
                                        </div>
                                    </div>
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
                                    @if($product->available_qty == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($product->available_qty <= 10)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports Row -->
<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Product Report</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportProductsToCSV()">
                        <i class="fas fa-file-csv me-1"></i>Export CSV
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h4 mb-0 text-primary">{{ $totalProducts ?? 0 }}</div>
                            <div class="text-muted small">Total Products</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h4 mb-0 text-warning">{{ $lowStockCount ?? 0 }}</div>
                            <div class="text-muted small">Low Stock</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h4 mb-0 text-success">{{ $totalSoldQty ?? 0 }}</div>
                        <div class="text-muted small">Total Sold</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Sold</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="me-2" 
                                                 style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 24px; height: 24px;">
                                                <i class="fas fa-image text-muted" style="font-size: 10px;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold small">{{ $product->name }}</div>
                                            <div class="text-muted small">{{ $product->size }} | {{ $product->color }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $product->available_qty <= 10 ? 'bg-warning' : 'bg-success' }}">
                                        {{ $product->available_qty }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->total_sold }}</span>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Client Report</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportClientsToCSV()">
                        <i class="fas fa-file-csv me-1"></i>Export CSV
                    </button>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h4 mb-0 text-primary">{{ $totalClients ?? 0 }}</div>
                            <div class="text-muted small">Total Clients</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <div class="h4 mb-0 text-success">{{ $activeClients ?? 0 }}</div>
                            <div class="text-muted small">Active Clients</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h4 mb-0 text-info">{{ $totalOrders ?? 0 }}</div>
                        <div class="text-muted small">Total Orders</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Last Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topClients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 24px; height: 24px;">
                                            <span class="text-white small fw-bold" style="font-size: 10px;">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-bold small">{{ $client->name }}</div>
                                            <div class="text-muted small">{{ $client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $client->purchases_count }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">${{ number_format($client->total_spent, 2) }}</span>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        {{ $client->last_purchase_date ? $client->last_purchase_date->format('M d, Y') : 'No orders' }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Admin Inventory Chart
const adminInventoryCtx = document.getElementById('adminInventoryChart').getContext('2d');
const adminInventoryChart = new Chart(adminInventoryCtx, {
    type: 'bar',
    data: {
        labels: @json($chartData['admins']),
        datasets: [{
            label: 'Total Inventory Quantity',
            data: @json($chartData['totals']),
            backgroundColor: [
                '#3b8ff3',
                '#34b1aa',
                '#e0b50f',
                '#f29f67',
                '#dc3545',
                '#6c757d'
            ],
            borderColor: [
                '#2d7dd2',
                '#2a9d96',
                '#c4a30c',
                '#e08a4a',
                '#c82333',
                '#5a6268'
            ],
            borderWidth: 2,
            borderRadius: 4,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Inventory Distribution by Admin',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Sales Analytics Chart
const salesAnalyticsCtx = document.getElementById('salesAnalyticsChart').getContext('2d');
const salesAnalyticsChart = new Chart(salesAnalyticsCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Sales',
            data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 32000, 35000, 40000, 38000, 45000],
            backgroundColor: 'rgba(59, 143, 243, 0.8)',
            borderColor: '#3b8ff3',
            borderWidth: 2,
            borderRadius: 4,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Product Categories Chart
const productCategoriesCtx = document.getElementById('productCategoriesChart').getContext('2d');
const productCategoriesChart = new Chart(productCategoriesCtx, {
    type: 'doughnut',
    data: {
        labels: ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports', 'Others'],
        datasets: [{
            data: [25, 20, 15, 18, 12, 10],
            backgroundColor: [
                '#34b1aa',
                '#e0b50f',
                '#dc3545',
                '#f29f67',
                '#3b8ff3',
                '#6c757d'
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Export functions
function exportReportToPDF() {
    console.log('Exporting report to PDF...');
    // Implement PDF export functionality
}

function exportReportToExcel() {
    console.log('Exporting report to Excel...');
    // Implement Excel export functionality
}

function exportProductsToCSV() {
    console.log('Exporting products to CSV...');
    // Implement products CSV export
}

function exportClientsToCSV() {
    console.log('Exporting clients to CSV...');
    // Implement clients CSV export
}

// Responsive chart resizing
window.addEventListener('resize', function() {
    adminInventoryChart.resize();
    salesAnalyticsChart.resize();
    productCategoriesChart.resize();
});
</script>
@endpush
@endsection
