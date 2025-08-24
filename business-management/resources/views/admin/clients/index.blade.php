@extends('admin.layouts.app')

@section('title', 'Clients')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clients</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Client
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.clients.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Search clients..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Clients</h6>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>
                                        <strong>{{ $client->name }}</strong>
                                        @if($client->purchases->count() > 0)
                                            <span class="badge bg-success ms-2">Active</span>
                                        @endif
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $client->total_purchases }}</span>
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
                                            <form action="{{ route('admin.clients.destroy', $client) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this client?')">
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
</div>
@endsection
