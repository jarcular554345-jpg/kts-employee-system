<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTS Car Rental - Employee Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #0dcaf0;
            --dark: #212529;
            --light: #f8f9fa;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1a1e2b 0%, #2d3748 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }
        
        .sidebar-header p {
            color: rgba(255,255,255,0.6);
            font-size: 0.75rem;
            margin: 5px 0 0 0;
        }
        
        .sidebar-header span {
            color: #4a90e2;
        }
        
        .nav-menu {
            padding: 0 15px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link-custom {
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            border-radius: 10px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .nav-link-custom i {
            width: 25px;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .nav-link-custom:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .nav-link-custom.active {
            background: #4a90e2;
            color: white;
            box-shadow: 0 2px 5px rgba(74,144,226,0.3);
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }
        
        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.7rem;
            color: #7f8c8d;
            margin: 0;
        }
        
        .avatar {
            width: 45px;
            height: 45px;
            background: #4a90e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        
        /* Content Area */
        .content-wrapper {
            padding: 25px;
        }
        
        /* Professional Cards */
        .card-professional {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
            margin-bottom: 25px;
            transition: all 0.3s;
        }
        
        .card-professional:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .card-header-professional {
            background: white;
            border-bottom: 2px solid #f0f2f5;
            padding: 18px 22px;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .card-body-professional {
            padding: 22px;
        }
        
        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            border-left: 4px solid;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7f8c8d;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-icon {
            font-size: 2.2rem;
            opacity: 0.7;
        }
        
        /* Tables */
        .table-professional {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-professional thead th {
            background: #f8f9fa;
            padding: 14px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table-professional tbody td {
            padding: 14px 16px;
            font-size: 0.85rem;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        
        .table-professional tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Buttons */
        .btn-professional {
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.2s;
        }
        
        .btn-professional-primary {
            background: #4a90e2;
            color: white;
            border: none;
        }
        
        .btn-professional-primary:hover {
            background: #357abd;
            transform: translateY(-1px);
        }
        
        .btn-professional-success {
            background: #28a745;
            color: white;
            border: none;
        }
        
        .btn-professional-danger {
            background: #dc3545;
            color: white;
            border: none;
        }
        
        .btn-professional-warning {
            background: #ffc107;
            color: #212529;
            border: none;
        }
        
        /* Badges */
        .badge-professional {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .badge-active { background: #d4edda; color: #155724; }
        .badge-inactive { background: #f8d7da; color: #721c24; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
        
        /* Forms */
        .form-professional {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .form-professional:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74,144,226,0.1);
            outline: none;
        }
        
        label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 5px;
        }
        
        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 15px 25px;
            text-align: center;
            font-size: 0.75rem;
            color: #7f8c8d;
        }
        
        /* Dropdown */
        .dropdown-menu-professional {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 8px 0;
        }
        
        /* Alerts */
        .alert-professional {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><span>KTS</span> Car Rental</h3>
            <p>Employee Management System</p>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.employees.index') }}" class="nav-link-custom {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Employee Management
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.attendance.index') }}" class="nav-link-custom {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-fingerprint"></i> Attendance Tracking
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.leave-requests.index') }}" class="nav-link-custom {{ request()->routeIs('admin.leave-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text"></i> Leave Requests
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.payrolls.index') }}" class="nav-link-custom {{ request()->routeIs('admin.payrolls.*') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i> Payroll Management
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link-custom {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Reports Center
                </a>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-nav">
            <h4 class="page-title">@yield('title', 'Dashboard Overview')</h4>
            <div class="user-menu">
                <div class="user-info">
                    <p class="user-name">{{ Auth::user()->name }}</p>
                    <p class="user-role">System Administrator</p>
                </div>
                <div class="dropdown">
                    <div class="avatar" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-professional">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-professional">
                    <i class="fas fa-check-circle me-2"></i> {!! session('success') !!}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-professional">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
        
        <div class="footer">
            <p class="mb-0">© {{ date('Y') }} KTS Car Rental System. Version 2.0 | All Rights Reserved</p>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>