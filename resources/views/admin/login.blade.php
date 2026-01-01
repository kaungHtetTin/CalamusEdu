<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('public/css/mdb.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/css/admin.css')}}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Calamus Education</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #1967d2 0%, #1557b0 30%, #0d47a1 60%, #1967d2 100%);
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(25, 103, 210, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(21, 87, 176, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(25, 103, 210, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Window Container */
        .window-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        /* Window Title Bar */
        .window-title-bar {
            background: linear-gradient(135deg, #1967d2 0%, #1557b0 100%);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: default;
            user-select: none;
        }
        
        .window-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .window-title i {
            font-size: 16px;
        }
        
        .window-controls {
            display: flex;
            gap: 8px;
        }
        
        .window-control {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .window-control.close {
            background: #ff5f57;
        }
        
        .window-control.minimize {
            background: #ffbd2e;
        }
        
        .window-control.maximize {
            background: #28ca42;
        }
        
        .window-control:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }
        
        /* Window Content */
        .window-content {
            padding: 40px 35px;
            background: #ffffff;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            font-size: 32px;
            font-weight: 300;
            color: #333;
            margin-bottom: 8px;
        }
        
        .login-header p {
            font-size: 14px;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 13px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #1967d2;
            box-shadow: 0 0 0 3px rgba(25, 103, 210, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1967d2 0%, #1557b0 100%);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(25, 103, 210, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(25, 103, 210, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .text-danger {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
        /* Footer */
        .window-footer {
            background: #f5f5f5;
            padding: 12px 16px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .window-container {
                max-width: 100%;
                border-radius: 0;
            }
            
            .window-content {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Window Container -->
    <div class="window-container">
        <!-- Window Title Bar -->
        <div class="window-title-bar">
            <div class="window-title">
                <i class="fas fa-lock"></i>
                <span>Admin Login</span>
            </div>
            <div class="window-controls">
                <div class="window-control minimize" title="Minimize"></div>
                <div class="window-control maximize" title="Maximize"></div>
                <div class="window-control close" title="Close"></div>
            </div>
        </div>
        
        <!-- Window Content -->
        <div class="window-content">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Calamus Education Admin Dashboard</p>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="id_number">ID Number</label>
                    <input 
                        type="text" 
                        class="form-control @error('id_number') is-invalid @enderror" 
                        id="id_number" 
                        name="id_number" 
                        placeholder="Enter admin ID"
                        value="{{ old('id_number') }}"
                        required
                    >
                    @error('id_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Enter password"
                        required
                        autofocus
                    >
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Login
                </button>
            </form>
        </div>
        
        <!-- Window Footer -->
        <div class="window-footer">
            Calamus Education © 2025
        </div>
    </div>
</body>
</html>
