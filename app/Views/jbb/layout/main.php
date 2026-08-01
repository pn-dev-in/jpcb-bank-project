<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JBB Technologies – Support Portal</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #198754;
            --primary-dark: #146c43;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
        }
        
        .jbb-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .jbb-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .jbb-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .jbb-sidebar-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .jbb-sidebar-header small {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
        }
        
        .jbb-nav {
            padding: 15px 0;
        }
        
        .jbb-nav .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .jbb-nav .nav-link:hover,
        .jbb-nav .nav-link.active {
            background: rgba(25, 135, 84, 0.15);
            color: #fff;
            border-left-color: var(--primary);
        }
        
        .jbb-nav .nav-link i {
            width: 20px;
            font-size: 16px;
        }
        
        .jbb-sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .jbb-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .jbb-user-avatar {
            width: 38px;
            height: 38px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #fff;
        }
        
        .jbb-user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
        }
        
        .jbb-user-role {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
        }
        
        /* Main Content */
        .jbb-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            width: calc(100% - var(--sidebar-width));
        }
        
        .jbb-topbar {
            background: #fff;
            padding: 12px 25px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .jbb-topbar h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }
        
        .jbb-content {
            padding: 25px;
        }
        
        /* Cards */
        .jbb-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 20px;
        }
        
        .jbb-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            font-size: 15px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .jbb-card-body {
            padding: 20px;
        }
        
        /* Stats Cards */
        .stat-card {
            padding: 20px;
            border-radius: 12px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 40px;
            opacity: 0.2;
        }
        
        /* Tables */
        .jbb-table {
            width: 100%;
        }
        
        .jbb-table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 12px 15px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
        }
        
        .jbb-table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
            font-size: 13px;
        }
        
        .jbb-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Badges */
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        /* Priority dots */
        .priority-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        /* Buttons */
        .btn-jbb-primary {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }
        
        .btn-jbb-primary:hover {
            background: var(--primary-dark);
            color: #fff;
        }
        
        /* Chat Style */
        .chat-message {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            max-width: 75%;
        }
        
        .chat-message.jbb {
            background: #d1e7dd;
            margin-left: auto;
        }
        
        .chat-message.jpcb {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .chat-message.system {
            background: #fff3cd;
            text-align: center;
            max-width: 100%;
            font-size: 12px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .jbb-sidebar {
                transform: translateX(-100%);
            }
            .jbb-sidebar.open {
                transform: translateX(0);
            }
            .jbb-main {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="jbb-wrapper">

    <!-- Sidebar -->
    <aside class="jbb-sidebar" id="jbbSidebar">
        <div class="jbb-sidebar-header">
            <i class="fas fa-headset" style="font-size:28px;color:var(--primary);"></i>
            <h4 class="mt-2">JBB Support</h4>
            <small>Technologies Portal</small>
        </div>
        
        <nav class="jbb-nav">
            <a href="<?= base_url('jbb/tickets') ?>" 
               class="nav-link <?= url_is('jbb/tickets') || url_is('jbb/tickets/*') ? 'active' : '' ?>">
                <i class="fas fa-ticket-alt"></i> All Tickets
            </a>
        </nav>
        
        <div class="jbb-sidebar-footer">
            <div class="jbb-user-info">
                <div class="jbb-user-avatar">
                    <?= strtoupper(substr(session('jbb_user_name') ?? 'U', 0, 1)) ?>
                </div>
                <div>
                    <div class="jbb-user-name"><?= esc(session('jbb_user_name')) ?></div>
                    <div class="jbb-user-role">Support Agent</div>
                </div>
                <a href="<?= base_url('jbb/logout') ?>" class="btn btn-sm btn-outline-light ms-auto" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="jbb-main">
        <!-- Top Bar -->
        <div class="jbb-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('jbbSidebar').classList.toggle('open')">
                    <i class="fas fa-bars"></i>
                </button>
                <h5>Support Tickets</h5>
            </div>
            <div>
                <span class="text-muted" style="font-size:12px;">
                    <i class="far fa-clock"></i> <?= date('d M Y, h:i A') ?>
                </span>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="jbb-content">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>