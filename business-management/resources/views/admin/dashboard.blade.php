@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-stats">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-dollar-sign text-white fa-lg"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="card-title">Total Sales</div>
                    <div class="card-text">${{ number_format($totalSales ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-stats">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-shopping-cart text-white fa-lg"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="card-title">Total Orders</div>
                    <div class="card-text">{{ $totalOrders ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-stats">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-users text-white fa-lg"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="card-title">Total Clients</div>
                    <div class="card-text">{{ $totalClients ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-stats">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-box text-white fa-lg"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="card-title">Total Products</div>
                    <div class="card-text">{{ $totalProducts ?? 0 }}</div>
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
                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Product Distribution</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="productsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Row -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Purchases</h5>
                <a href="{{ route('admin.purchases.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="recentPurchasesTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPurchases as $purchase)
                            <tr>
                                <td><strong>#{{ $purchase->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <span class="text-white small fw-bold">{{ substr($purchase->client->name, 0, 1) }}</span>
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
                                            <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="{{ $purchase->product->name }}" class="me-2" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $purchase->product->name }}</div>
                                            <div class="text-muted small">{{ $purchase->product->size }} | {{ $purchase->product->color }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>${{ number_format($purchase->total_amount, 2) }}</strong></td>
                                <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Products</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($lowStockProducts as $product)
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="me-3" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $product->name }}</div>
                                <div class="text-muted small">{{ $product->size }} | {{ $product->color }}</div>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-warning me-2">Low Stock</span>
                                    <span class="text-muted small">{{ $product->available_qty }} units left</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">${{ number_format($product->price, 2) }}</div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales',
            data: [12000, 19000, 15000, 25000, 22000, 30000],
            borderColor: '#3b8ff3',
            backgroundColor: 'rgba(59, 143, 243, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b8ff3',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
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

// Products Chart
const productsCtx = document.getElementById('productsChart').getContext('2d');
const productsChart = new Chart(productsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Electronics', 'Clothing', 'Books', 'Home & Garden'],
        datasets: [{
            data: [35, 25, 20, 20],
            backgroundColor: [
                '#3b8ff3',
                '#34b1aa',
                '#e0b50f',
                '#f29f67'
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
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

// Recent Purchases DataTable
$(document).ready(function() {
    $('#recentPurchasesTable').DataTable({
        responsive: true,
        pageLength: 5,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: false,
        language: {
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        }
    });
});

// Responsive chart resizing
window.addEventListener('resize', function() {
    salesChart.resize();
    productsChart.resize();
});
</script>
@endpush
@endsection
