<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTS Car Rental - Employee Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d6efd;
            --dark: #1a1e2b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }
        
        .navbar-corporate {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            padding: 12px 0;
        }
        
        .brand {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            text-decoration: none;
        }
        
        .brand span {
            color: var(--primary);
        }
        
        .brand small {
            font-size: 0.7rem;
            font-weight: 400;
            color: #7f8c8d;
        }
        
        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            overflow: hidden;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .employee-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .employee-avatar i {
            font-size: 1.5rem;
            color: white;
        }
        
        .content-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 25px;
        }
        
        .card-corporate {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin-bottom: 25px;
        }
        
        .card-header-corporate {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 18px 22px;
            font-weight: 600;
        }
        
        .footer-corporate {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 15px 0;
            text-align: center;
            font-size: 0.75rem;
            color: #7f8c8d;
            margin-top: 30px;
        }
        
        .btn-corporate {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .table-corporate {
            width: 100%;
        }
        
        .table-corporate thead th {
            background: #f8f9fa;
            padding: 12px 16px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table-corporate tbody td {
            padding: 12px 16px;
            font-size: 0.85rem;
            border-bottom: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <nav class="navbar-corporate">
        <div class="container">
            <a class="brand" href="#">
                <span>KTS</span> Car Rental
                <small>Employee Portal</small>
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-muted">{{ Auth::user()->name }}</span>
                <div class="dropdown">
                    <div class="employee-avatar" data-bs-toggle="dropdown">
                        @php
                            $employee = Auth::user()->employee;
                            $avatarUrl = $employee && $employee->profile_picture && file_exists(public_path('storage/' . $employee->profile_picture)) 
                                ? asset('storage/' . $employee->profile_picture) 
                                : null;
                        @endphp
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Avatar">
                        @else
                            <i class="fas fa-user-circle"></i>
                        @endif
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.profile.edit') }}">
                                <i class="fas fa-user-circle me-2"></i> My Profile
                            </a>
                        </li>
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
    </nav>
    
    <div class="content-container">
        @yield('content')
    </div>
    
    <div class="footer-corporate">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} KTS Car Rental. All Rights Reserved.</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>