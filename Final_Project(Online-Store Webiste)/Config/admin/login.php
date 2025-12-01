<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CyberCart Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        
        .login-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 40px 30px;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .login-header {
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #1a1a2e;
            font-size: 28px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .login-header h1 i {
            color: #4cc9f0;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4cc9f0;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.1);
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 201, 240, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 201, 240, 0.4);
        }
        
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            font-weight: 500;
        }
        
        .demo-credentials {
            margin-top: 25px;
            padding: 20px;
            background: #f0f9ff;
            border-radius: 8px;
            border-left: 4px solid #4cc9f0;
        }
        
        .demo-credentials strong {
            color: #1a1a2e;
            margin-bottom: 10px;
            display: block;
        }
        
        .demo-credentials code {
            background: white;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #e1e5e9;
            font-family: monospace;
            color: #1a1a2e;
        }
        
        @media (max-width: 480px) {
            .login-box {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1><i class="fas fa-lock"></i>Admin Login</h1>
                <p>CyberCart Store Administration Panel</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-key"></i> Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="demo-credentials">
                <strong>Demo Credentials:</strong>
                <div style="margin-top: 8px;">
                    <div style="margin-bottom: 5px;">
                        <i class="fas fa-user"></i> Username: <code>admin</code>
                    </div>
                    <div>
                        <i class="fas fa-key"></i> Password: <code>admin123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            const loginBtn = document.querySelector('.btn-primary');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
                loginBtn.disabled = true;
            });
            
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>
