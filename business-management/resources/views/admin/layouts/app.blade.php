<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Management')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <style>
        :root {
            --primary-color: #3b8ff3;
            --primary-dark: #1e1e2c;
            --primary-accent: #f29f67;
            --success-color: #34b1aa;
            --warning-color: #e0b50f;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #1e1e2c;
            --text-primary: #1e1e2c;
            --text-secondary: #6c757d;
            --border-color: #dee2e6;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, #2a2a3a 100%);
            box-shadow: var(--shadow);
            z-index: 1000;
            transition: all 0.3s ease;
            border-radius: 0 var(--border-radius-lg) var(--border-radius-lg) 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 0.75rem 1.25rem;
            border-radius: var(--border-radius);
            margin: 0.25rem 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-accent);
            color: white !important;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
            box-shadow: var(--shadow-sm);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover i {
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 1.25rem;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Topbar with Gradient */
        .topbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            padding: 1rem 1.25rem;
            margin: -1.25rem -1.25rem 1.25rem -1.25rem;
            border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .topbar .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .topbar .form-control {
            border-radius: var(--border-radius);
            border: none;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.5rem 1rem;
            width: 300px;
        }

        .topbar .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .topbar .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            background: white;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--success-color) 100%);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
            padding: 1rem 1.25rem;
            border: none;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Stats Cards */
        .card-stats {
            border-radius: var(--border-radius-lg);
            background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .card-stats:hover {
            box-shadow: var(--shadow);
            transform: translateY(-3px);
        }

        .card-stats .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .card-stats .card-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0;
        }

        /* Button Styles */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.875rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2d7dd2;
            border-color: #2d7dd2;
            transform: translateY(-1px);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #2a9d96;
            border-color: #2a9d96;
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-warning:hover {
            background-color: #c4a30c;
            border-color: #c4a30c;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 0.5rem 0.75rem;
            box-shadow: var(--shadow-sm);
            background-color: white;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(59, 143, 243, 0.25);
        }

        /* FilePond Styles */
        .filepond--root {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .filepond--panel-root {
            background-color: white;
            border: 1px solid var(--border-color);
        }

        .filepond--drop-label {
            color: var(--text-secondary);
        }

        /* Table Styles */
        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table {
            margin-bottom: 0;
            border-radius: var(--border-radius);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem 0.75rem;
            font-size: 0.875rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(59, 143, 243, 0.05);
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-color: var(--border-color);
        }

        /* Badge Styles */
        .badge {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.375rem 0.75rem;
        }

        .bg-success {
            background-color: var(--success-color) !important;
        }

        .bg-warning {
            background-color: var(--warning-color) !important;
        }

        .bg-danger {
            background-color: var(--danger-color) !important;
        }

        /* DataTables Custom Styles */
        .dataTables_wrapper {
            padding: 1rem 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 0.375rem 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            margin: 0 0.125rem;
            padding: 0.375rem 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white !important;
        }

        /* Typography */
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .topbar {
                margin: -1rem -1rem 1rem -1rem;
                padding: 0.75rem 1rem;
            }

            .topbar .form-control {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            h1 {
                font-size: 1.25rem;
            }

            h2 {
                font-size: 1.125rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-stats {
                padding: 1rem;
            }
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            border-radius: var(--border-radius);
            padding: 0.5rem;
            margin-right: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
        }

        /* Alert Styles */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-sm);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius-lg);
            border: none;
            box-shadow: var(--shadow);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--success-color) 100%);
            color: white;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            background: white;
            padding: 1rem;
        }

        /* Loading Spinner */
        .spinner-border {
            color: var(--primary-color);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: var(--border-radius);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: var(--border-radius);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="d-flex flex-column h-100">
            <div class="p-3">
                <h4 class="text-white mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Business Manager
                </h4>
            </div>
            
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}" href="{{ route('admin.clients.index') }}">
                        <i class="fas fa-users"></i>
                        Clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}" href="{{ route('admin.purchases.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Purchases
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        Reports
                    </a>
                </li>
            </ul>
            
            <div class="p-3 border-top border-secondary">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-white fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">Administrator</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="mb-0 text-white">@yield('title', 'Dashboard')</h1>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                        <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-1"></i>
                            Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="exportToCSV()"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                            <li><a class="dropdown-item" href="#" onclick="exportToPDF()"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#" onclick="exportToExcel()"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container-fluid p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    <script>
        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        // Sidebar toggle functionality
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

        // Export functions (placeholder)
        function exportToCSV() {
            console.log('Export to CSV');
        }

        function exportToPDF() {
            console.log('Export to PDF');
        }

        function exportToExcel() {
            console.log('Export to Excel');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        });

        // Responsive sidebar behavior
        function handleResize() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar').classList.remove('show');
            }
        }

        window.addEventListener('resize', handleResize);
    </script>

    @stack('scripts')
</body>
</html>
