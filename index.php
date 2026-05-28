<!-- Vinjet Estates - Real Estate Management System -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinjet Estates - Real Estate Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-left p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .login-right {
            padding: 60px 40px;
        }

        .login-right h3 {
            color: #333;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ddd;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            width: 100%;
            transition: transform 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .demo-credentials {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .demo-credentials h6 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .demo-credentials p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="login-container">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div class="login-left">
                                <h2>Vinjet Estates</h2>
                                <p>Professional Real Estate Management System</p>
                                <p style="margin-top: 30px; font-size: 0.95rem;">
                                    <i class="fas fa-check-circle"></i> Manage agents and properties<br>
                                    <i class="fas fa-check-circle"></i> Track transactions seamlessly<br>
                                    <i class="fas fa-check-circle"></i> Generate detailed reports<br>
                                    <i class="fas fa-check-circle"></i> Real-time notifications
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="login-right">
                                <h3><i class="fas fa-sign-in-alt"></i> Login</h3>

                                <?php
                                session_start();
                                if (isset($_GET['error'])) {
                                    echo '<div class="error-message"><i class="fas fa-exclamation-circle"></i> ' . htmlspecialchars($_GET['error']) . '</div>';
                                }
                                if (isset($_GET['success'])) {
                                    echo '<div class="success-message"><i class="fas fa-check-circle"></i> ' . htmlspecialchars($_GET['success']) . '</div>';
                                }
                                if (isset($_SESSION['user_id'])) {
                                    header('Location: pages/dashboard.php');
                                    exit;
                                }
                                ?>

                                <form method="POST" action="api/login.php">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>

                                    <button type="submit" class="btn btn-login btn-primary">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>
                                </form>

                                <div class="register-link">
                                    Don't have an account? <a href="pages/register.php"><i class="fas fa-user-plus"></i> Register here</a>
                                </div>

                                <div class="demo-credentials">
                                    <h6><i class="fas fa-user-secret"></i> Demo Credentials</h6>
                                    <p><strong>Admin:</strong><br>admin@vinjet.com | Admin@123</p>
                                    <p><strong>Agent:</strong><br>agent@vinjet.com | Agent@123</p>
                                    <p><strong>Client:</strong><br>client@vinjet.com | Client@123</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
