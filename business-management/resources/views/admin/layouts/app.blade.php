<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Management') - Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem 0.5rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: #495057;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                z-index: 1000;
                transition: left 0.3s;
            }
            
            .sidebar.show {
                left: 0;
            }
        }
        
        .card-stats {
            transition: transform 0.2s;
        }
        
        .card-stats:hover {
            transform: translateY(-5px);
        }
        
        .table-responsive {
            border-radius: 0.375rem;
        }
        
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link text-light d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-building"></i> Business Management
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-dark collapse" id="sidebar">
            <div class="position-sticky pt-5">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                           href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}" 
                           href="{{ route('admin.clients.index') }}">
                            <i class="bi bi-people"></i> Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}" 
                           href="{{ route('admin.purchases.index') }}">
                            <i class="bi bi-cart"></i> Purchases
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                           href="{{ route('admin.reports.index') }}">
                            <i class="bi bi-graph-up"></i> Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="pt-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
