<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTS Car Rental - Reset Password</title>
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
            overflow-x: hidden;
        }
        
        .auth-container {
            display: flex;
            min-height: 100vh;
        }
        
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(26,30,43,0.9) 0%, rgba(0,0,0,0.8) 100%),
                        url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 50px;
            color: white;
        }
        
        .brand {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .brand span {
            color: #4a90e2;
        }
        
        .left-content {
            max-width: 400px;
        }
        
        .left-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .left-title span {
            color: #4a90e2;
        }
        
        .left-text {
            font-size: 0.9rem;
            opacity: 0.8;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .features {
            list-style: none;
            padding: 0;
        }
        
        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
        }
        
        .features li i {
            color: #4a90e2;
            width: 20px;
        }
        
        .copyright {
            font-size: 0.7rem;
            opacity: 0.5;
        }
        
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 40px;
        }
        
        .form-container {
            max-width: 400px;
            width: 100%;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1e2b;
            margin-bottom: 8px;
        }
        
        .form-header p {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 11px 15px 11px 42px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74,144,226,0.1);
            outline: none;
        }
        
        .btn-reset {
            width: 100%;
            padding: 12px;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-reset:hover {
            background: #357abd;
            transform: translateY(-1px);
        }
        
        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.8rem;
        }
        
        .back-link a {
            color: #4a90e2;
            text-decoration: none;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .alert-custom {
            padding: 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }
            .auth-left {
                padding: 40px 30px;
                min-height: 40vh;
            }
            .left-title {
                font-size: 1.8rem;
            }
            .auth-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <div class="brand">
                <span>KTS</span> Car Rental
            </div>
            
            <div class="left-content">
                <h1 class="left-title">
                    Reset Your <span>Password</span>
                </h1>
                <p class="left-text">
                    Don't worry, it happens to the best of us. We'll help you get back into your account.
                </p>
                <ul class="features">
                    <li><i class="fas fa-check-circle"></i> Quick password recovery</li>
                    <li><i class="fas fa-check-circle"></i> Secure verification process</li>
                    <li><i class="fas fa-check-circle"></i> 24/7 support available</li>
                </ul>
            </div>
            
            <div class="copyright">
                <p>© {{ date('Y') }} KTS Car Rental. All rights reserved.</p>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="form-container">
                <div class="form-header">
                    <h2>Forgot Password</h2>
                    <p>Enter your email to reset password</p>
                </div>
                
                @if (session('status'))
                    <div class="alert alert-success alert-custom">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-custom">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="admin@kts.com" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-reset">Send Reset Link</button>
                </form>
                
                <div class="back-link">
                    <a href="{{ route('login') }}">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>