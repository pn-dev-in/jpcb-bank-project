<?php
$titleText = trim($this->renderSection('title'));
$pageTitle = $titleText !== '' ? $titleText : ($pageTitle ?? 'Admin Panel');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="light" data-sidenav-view="default">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle) ?> | JPCB Bank Admin</title>

    <link rel="icon" type="image/svg+xml" href="<?= base_url('favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon.svg') ?>">
    <link href="<?= base_url('admin-assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('admin-assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?= base_url('admin-assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css">

    <style>
        .topbar-user-name {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .side-nav-link.active {
            background-color: rgba(var(--bs-primary-rgb), 0.12);
            color: var(--bs-primary) !important;
        }

        .side-nav-link.active .menu-icon i,
        .side-nav-link.active .menu-text {
            color: var(--bs-primary) !important;
        }

        .flash-list .alert {
            margin-bottom: 0.75rem;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>
<body>
<div class="wrapper">
    <?= view('shared/layout/topbar', ['pageTitle' => $pageTitle, 'role' => 'admin']) ?>
    <?= $this->include('shared/layout/sidebar_admin') ?>

    <div class="page-content">
        <div class="page-container py-2">
        
            <div class="flash-list">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= esc((string) session()->getFlashdata('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= esc((string) session()->getFlashdata('error')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session('errors') && is_array(session('errors'))): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <?= $this->renderSection('content') ?>
        </div>

        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-12 text-center text-muted small">
                        <?= date('Y') ?> JPCB Bank Admin Panel
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="<?= base_url('admin-assets/js/vendor.min.js') ?>"></script>
<script src="<?= base_url('admin-assets/js/app.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>