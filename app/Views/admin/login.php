<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>Admin Login | JPCB Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Adminto CSS -->
    <link href="<?= base_url('admin-assets/css/vendor.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('admin-assets/css/app.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('admin-assets/css/icons.min.css') ?>" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fb;
            height: 100vh;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        /* BACKGROUND IMAGE (centered properly) */
        .bg-image {
            position: absolute;
            inset: 0;
            background: url("<?= base_url('assets/images/login-bg.jpg') ?>") no-repeat center center;
            background-size: cover; /* IMPORTANT: prevents crop */
            opacity: 0.25;
        }

        /* LOGIN CENTER */
        .login-wrapper {
            position: relative;
            z-index: 2;
            height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
        }

        .bank-logo {
            max-height: 60px;
            object-fit: contain;
        }
    </style>
</head>

<body>

<!-- BACKGROUND -->
<div class="bg-image"></div>

<!-- LOGIN -->
<div class="login-wrapper d-flex align-items-center justify-content-center">

    <div class="card login-card shadow-lg p-4">

        <!-- LOGO -->
        <div class="text-center mb-4">

    <!-- LOGO -->
    <img src="<?= base_url('assets/images/bank-logo.png') ?>"
         alt="JPCB Bank"
         style="width: auto; max-width: 100%; max-height: 60px; object-fit: contain;">

    <!-- GAP -->
    <div style="height: 15px;"></div>

    <!-- TITLE -->
    <h4 class="fw-bold mb-1">JPCB Admin Panel</h4>

    <!-- SUBTITLE -->
    <p class="text-muted mb-0">Login to continue</p>

</div>

        <!-- ERROR -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form method="post" action="<?= base_url('admin/login') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input">
                    <label class="form-check-label">Remember me</label>
                </div>
                <a href="#" class="small text-muted">Forgot?</a>
            </div>

            <button class="btn btn-success w-100">Login</button>
        </form>

        <div class="text-center mt-3 text-muted small">
            © <?= date('Y') ?> JPCB Bank
        </div>

    </div>

</div>

<script src="<?= base_url('admin-assets/js/vendor.min.js') ?>"></script>
<script src="<?= base_url('admin-assets/js/app.js') ?>"></script>

</body>
</html>