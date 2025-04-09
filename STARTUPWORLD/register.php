<?php
session_start();
require_once 'includes/functions.php';

// Check for referral code in URL
if (isset($_GET['ref'])) {
    $refCode = sanitizeInput($_GET['ref']);
    if (!empty($refCode)) {
        $_SESSION['referral_code'] = $refCode;
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'process_register.php';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - StartupWorld</title>
    <link rel="stylesheet" href="assets/css/referral.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2><i class="fas fa-user-plus"></i> Create Your Account</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <?php if (isset($_SESSION['referral_code'])): ?>
                    <div class="referral-notice">
                        <i class="fas fa-user-friends"></i> You were referred by <?php echo htmlspecialchars($_SESSION['referral_code']); ?>
                        <input type="hidden" name="referral_code" value="<?php echo htmlspecialchars($_SESSION['referral_code']); ?>">
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>
                
                <div class="login-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
        </div>
    </div>
    
    <style>
        .register-form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .register-btn {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .register-btn:hover {
            background: #2980b9;
        }
        
        .referral-notice {
            background: #e8f4fc;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            color: #2980b9;
        }
        
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .error {
            background: #fdecea;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .success {
            background: #e8f5e9;
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
        
        .login-link {
            margin-top: 15px;
            text-align: center;
            color: #7f8c8d;
        }
        
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>