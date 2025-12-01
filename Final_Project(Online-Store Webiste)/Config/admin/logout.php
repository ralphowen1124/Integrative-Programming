<?php
session_start();

$username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - CyberCart Store</title>
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
        
        .logout-container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        .logout-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
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
        
        .logout-icon {
            font-size: 64px;
            color: #4cc9f0;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .logout-header h1 {
            color: #1a1a2e;
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .logout-message {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .user-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #4cc9f0;
        }
        
        .user-info strong {
            color: #1a1a2e;
        }
        
        .countdown {
            font-size: 16px;
            color: #4cc9f0;
            font-weight: bold;
            margin: 20px 0;
        }
        
        .redirect-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(76, 201, 240, 0.3);
        }
        
        .redirect-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 201, 240, 0.4);
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4cc9f0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 480px) {
            .logout-box {
                padding: 40px 25px;
            }
            
            .logout-header h1 {
                font-size: 28px;
            }
            
            .logout-icon {
                font-size: 48px;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-box">
            <div class="logout-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            
            <div class="logout-header">
                <h1>Logged Out Successfully</h1>
            </div>
            
            <div class="logout-message">
                You have been successfully logged out of the CyberCart Store Admin Panel.
            </div>
            
            <div class="user-info">
                <i class="fas fa-user"></i> User: <strong><?php echo htmlspecialchars($username); ?></strong>
            </div>
            
            <div class="spinner"></div>
            
            <div class="countdown" id="countdown">
                Redirecting to login page in <span id="countdown-number">5</span> seconds...
            </div>
            
            <a href="login.php?logout=success" class="redirect-link">
                <i class="fas fa-arrow-right"></i> Go to Login Page Now
            </a>
        </div>
    </div>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown-number');
        
        const countdownInterval = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = 'login.php?logout=success';
            }
        }, 1000);
        
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.logout-message, .user-info, .redirect-link');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 300 + (index * 100));
            });
        });
    </script>
</body>
</html>
