<?php
session_start();

// Get redirect URL from parameter
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';

// Show error if login failed
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Vinjet Estates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 28px;
        }

        .card-header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .help-text {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .help-text p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .help-text a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .help-text a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #0d6efd;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .form-icon {
            position: relative;
        }

        .form-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0d6efd;
        }

        .form-icon-input {
            padding-left: 45px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="card-header">
            <h3><i class="fas fa-home"></i> Vinjet Estates</h3>
            <p>Property Management System</p>
        </div>

        <div class="card-body">
            <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> 
                    <?php
                        if($error == 'invalid') {
                            echo 'Invalid email or password. Please try again.';
                        } elseif($error == 'required') {
                            echo 'Please fill in all fields.';
                        } else {
                            echo htmlspecialchars($error);
                        }
                    ?>
                </div>
            <?php endif; ?>

            <form action="process-login-smart.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="form-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control form-icon-input" 
                               placeholder="Enter your email" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="form-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control form-icon-input" 
                               placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="forgot-password">
                    <a href="#"><i class="fas fa-question-circle"></i> Forgot password?</a>
                </div>

                <!-- Hidden redirect field (will be handled by backend based on role) -->
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="help-text">
                <p>Don't have an account? <a href="register.php">Sign up here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>