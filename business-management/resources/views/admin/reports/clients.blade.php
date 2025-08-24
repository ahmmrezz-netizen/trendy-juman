@extends('admin.layouts.app')

@section('title', 'Clients Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clients Report</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeClients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Purchases</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPurchases }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                New This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newThisMonth }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detailed Clients Report</h6>
        </div>
        <div class="card-body">
            @if($clients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Purchases</th>
                                <th>Last Purchase</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>
                                        <strong>{{ $client->name }}</strong>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $client->total_purchases }}</span>
                                    </td>
                                    <td>
                                        @if($client->last_purchase_date)
                                            {{ $client->last_purchase_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($client->total_purchases > 0)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.clients.show', $client) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.clients.edit', $client) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $clients->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h5 class="text-muted mt-3">No clients found</h5>
                    <p class="text-muted">Start by adding your first client.</p>
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Client
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Clients -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top Clients by Purchase Volume</h6>
        </div>
        <div class="card-body">
            @if($topClients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Client</th>
                                <th>Total Items Purchased</th>
                                <th>Last Purchase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topClients as $index => $client)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $client->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $client->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $client->purchases_sum_qty ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($client->last_purchase_date)
                                            {{ $client->last_purchase_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">No clients have made purchases yet.</p>
            @endif
        </div>
    </div>

    <!-- Recent Client Activity -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Client Activity</h6>
        </div>
        <div class="card-body">
            @if($recentActivity->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentActivity as $activity)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $activity->client->name }}</strong> purchased 
                                <strong>{{ $activity->qty }}</strong> x {{ $activity->product->name }}
                            </div>
                            <small class="text-muted">{{ $activity->purchase_date->format('M d, Y') }}</small>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center">No recent activity.</p>
            @endif
        </div>
    </div>
</div>
@endsection
