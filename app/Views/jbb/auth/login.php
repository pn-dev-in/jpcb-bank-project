<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JBB Technologies – Support Portal Login</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #198754;
            --primary-dark: #146c43;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        
        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 30px;
            text-align: center;
            color: #fff;
        }
        
        .login-header .logo-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 32px;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .login-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 22px;
        }
        
        .login-header p {
            margin: 5px 0 0;
            opacity: 0.8;
            font-size: 13px;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .login-body .form-label {
            font-weight: 600;
            color: #333;
            font-size: 13px;
            margin-bottom: 6px;
        }
        
        .login-body .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .login-body .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.1);
        }
        
        .login-body .input-group-text {
            background: #f8f9fa;
            border-right: none;
            border-radius: 8px 0 0 8px;
            color: #6c757d;
        }
        
        .login-body .form-control.with-icon {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
            color: #fff;
        }
        
        .login-footer {
            text-align: center;
            padding: 0 30px 25px;
            color: #6c757d;
            font-size: 12px;
        }
        
        .login-footer strong {
            color: var(--primary);
        }
        
        .alert {
            border-radius: 8px;
            font-size: 13px;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h3>JBB Technologies</h3>
            <p>Technical Support Portal</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <?php if (session('error')): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session('message')): ?>
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <?= session('message') ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="<?= base_url('jbb/login') ?>">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control with-icon" 
                               placeholder="Enter your email" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control with-icon" 
                               placeholder="Enter your password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="login-footer">
            <i class="fas fa-shield-alt"></i> Secure login for <strong>JBB Support Team</strong>
            <br>© <?= date('Y') ?> JBB Technologies. All rights reserved.
        </div>
    </div>
    
    <a href="https://jbbtechnologies.in" class="back-link" target="_blank">
        <i class="fas fa-globe"></i> Visit JBB Technologies Website
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>