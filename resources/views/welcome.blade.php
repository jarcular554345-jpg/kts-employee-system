<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KTS Car Rental - Employee Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            position: relative;
        }
        
        /* Professional Garage Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26,30,43,0.85) 0%, rgba(0,0,0,0.7) 100%),
                        url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            z-index: -2;
        }
        
        /* Navbar - Minimal */
        .navbar-custom {
            padding: 30px 0;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }
        
        .navbar-brand-custom {
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        
        .navbar-brand-custom span {
            color: #4a90e2;
        }
        
        /* Hero Section - Left Aligned */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            padding: 100px 20px 60px;
        }
        
        .hero-content {
            max-width: 650px;
            margin-left: 0;
            text-align: left;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }
        
        .hero-title span {
            color: #4a90e2;
        }
        
        .hero-subtitle {
            font-size: 0.95rem;
            opacity: 0.85;
            margin-bottom: 32px;
            line-height: 1.6;
            max-width: 550px;
        }
        
        /* Button Styles - Left Aligned */
        .btn-group-custom {
            display: flex;
            gap: 16px;
            justify-content: flex-start;
            flex-wrap: wrap;
        }
        
        .btn-custom-primary {
            background: #4a90e2;
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-custom-primary:hover {
            background: #357abd;
            transform: translateY(-1px);
            color: white;
        }
        
        .btn-custom-outline {
            background: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 10px 28px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-custom-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
            color: white;
        }
        
        /* Footer - Minimal */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            text-align: center;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            background: linear-gradient(0deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 100%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                align-items: flex-start;
                padding-top: 120px;
            }
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 0.85rem;
            }
            .btn-group-custom {
                gap: 12px;
            }
            .btn-custom-primary, .btn-custom-outline {
                padding: 8px 20px;
                font-size: 0.8rem;
            }
        }
        
        /* Animation */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .hero-content {
            animation: fadeInLeft 0.8s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar-custom">
        <div class="container">
            <a class="navbar-brand-custom" href="#">
                <span>KTS</span> Car Rental
            </a>
        </div>
    </nav>
    
    <!-- Hero Section - Left Aligned -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <span>KTS Car Rental</span><br>Employee Management System
                </h1>
                <p class="hero-subtitle">
                    A complete solution to manage your workforce, streamline operations, and improve productivity in your car rental business.
                </p>
                <div class="btn-group-custom">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-custom-primary">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-custom-primary">
                                Sign In
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-custom-outline">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} KTS Car Rental. All rights reserved.</p>
    </footer>
</body>
</html>