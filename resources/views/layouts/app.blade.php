<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KTS Car Rental') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #6c757d;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #334155;
        }
        
        /* Modern Card */
        .card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
        }
        
        .card-modern:hover {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.02);
        }
        
        /* Modern Button */
        .btn-modern {
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-modern-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-modern-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        /* Modern Table */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-modern thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table-modern tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        
        .table-modern tbody tr:hover {
            background: #f8fafc;
        }
        
        /* Modern Form */
        .form-modern {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .form-modern:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67,97,238,0.1);
            outline: none;
        }
        
        /* Modern Badge */
        .badge-modern {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e2e8f0;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .sidebar-item {
            padding: 10px 20px;
            margin: 4px 12px;
            border-radius: 10px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }
        
        .sidebar-item:hover {
            background: #f1f5f9;
            color: var(--primary);
        }
        
        .sidebar-item.active {
            background: var(--primary);
            color: white;
        }
        
        .sidebar-item i {
            width: 20px;
            font-size: 1rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px 30px;
        }
        
        /* Navbar */
        .navbar-modern {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar-modern">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="#">
                    <span style="color: var(--primary);">KTS</span> Car Rental
                </a>
                <div class="ms-auto">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>