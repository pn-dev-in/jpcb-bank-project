<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<!-- Page Title -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Dashboard</h3>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active">Welcome back, <?= session()->get('admin_name') ?? 'Admin' ?></li>
    </ol>
</div>

<!-- ========== 1. CORE METRICS CARDS ========== -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Total Complaints</div>
                    <i class="fas fa-file-alt fa-2x opacity-50"></i>
                </div>
                <h2 class="mt-2 mb-0"><?= $total ?></h2>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a class="small text-white stretched-link" href="<?= base_url('admin/complaints') ?>">View Details <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Pending Complaints</div>
                    <i class="fas fa-clock fa-2x opacity-50"></i>
                </div>
                <h2 class="mt-2 mb-0"><?= $pending ?></h2>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a class="small text-white stretched-link" href="<?= base_url('admin/complaints?status=Pending') ?>">View Details <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Resolved Complaints</div>
                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                </div>
                <h2 class="mt-2 mb-0"><?= $resolved ?></h2>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a class="small text-white stretched-link" href="<?= base_url('admin/complaints?status=Resolved') ?>">View Details <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Delayed (48h+)</div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                </div>
                <h2 class="mt-2 mb-0"><?= $delayed ?></h2>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a class="small text-white stretched-link" href="<?= base_url('admin/complaints?delayed=1') ?>">View Details <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ========== 2. CRITICAL ALERTS SECTION ========== -->
<?php if ($unassigned > 0 || $olderThan24h > 0): ?>
<div class="card border-danger mb-4">
    <div class="card-header bg-danger text-white py-2">
        <i class="fas fa-exclamation-triangle me-1"></i> Critical Alerts
    </div>
    <div class="card-body">
        <?php if ($unassigned > 0): ?>
        <div class="alert alert-warning mb-2 py-2">
            <strong>⚠️ <?= $unassigned ?></strong> complaint(s) are not assigned to any admin.
            <a href="<?= base_url('admin/complaints?unassigned=1') ?>" class="alert-link">Assign now</a>
        </div>
        <?php endif; ?>
        <?php if ($olderThan24h > 0): ?>
        <div class="alert alert-warning mb-0 py-2">
            <strong>🕒 <?= $olderThan24h ?></strong> complaint(s) older than 24 hours are still unresolved.
            <a href="<?= base_url('admin/complaints?old=1') ?>" class="alert-link">Review</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- ========== 3. RECENT COMPLAINTS TABLE ========== -->
<div class="card mb-4">
    <div class="card-header py-2">
        <i class="fas fa-table me-1"></i> Recent Complaints
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentComplaints)): ?>
                        <?php foreach ($recentComplaints as $c): ?>
                        <tr>
                            <td><?= esc($c['ticket_number'] ?? 'N/A') ?></td>
                            <td><?= esc($c['name']) ?></td>
                            <td>
                                <span class="badge bg-<?= $c['status'] == 'Pending' ? 'warning' : ($c['status'] == 'Resolved' ? 'success' : 'secondary') ?>">
                                    <?= esc($c['status']) ?>
                                </span>
                            </td>
                            <td><?= esc($c['assigned_admin_name'] ?? 'Unassigned') ?></td>
                            <td><?= date('d M Y H:i', strtotime($c['created_at'])) ?></td>
                            <td><a href="<?= base_url('admin/complaints/view/'.$c['id']) ?>" class="btn btn-sm btn-primary">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No complaints found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== 4. ASSIGNMENT OVERVIEW & 5. ANALYTICS ========== -->
<div class="row g-3 mb-4">
    <div class="col-xl-6 col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="fas fa-chart-pie me-1"></i> Admin Workload (Unresolved)
            </div>
            <div class="card-body p-0">
                <?php if (!empty($assignmentOverview)): ?>
                    <div class="list-group list-group-flush">
                    <?php foreach ($assignmentOverview as $admin): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <?= esc($admin['name']) ?>
                            <span class="badge bg-primary rounded-pill"><?= $admin['complaint_count'] ?> complaints</span>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-3 text-center text-muted">No assignments yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="fas fa-chart-line me-1"></i> Analytics (Last 30 Days)
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Complaints this week:</strong> <?= $complaintsThisWeek ?>
                </div>
                <div class="mb-3">
                    <strong>Complaints this month:</strong> <?= $complaintsThisMonth ?>
                </div>
                <div class="mb-3">
                    <strong>Resolution rate (month):</strong> <?= $resolutionRate ?>%
                    <div class="progress mt-1" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $resolutionRate ?>%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Average resolution time:</strong> <?= $avgResolution ?> hours
                </div>
                <div class="mb-3">
                    <strong>SLA compliance (48h):</strong> <?= $slaCompliance ?>%
                    <div class="progress mt-1" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $slaCompliance ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== 6. ACTIVITY LOG ========== -->
<div class="card mb-4">
    <div class="card-header py-2">
        <i class="fas fa-history me-1"></i> Recent Activity Log
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr><th>Admin</th><th>Action</th><th>Module</th><th>Time</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($activityLog)): ?>
                        <?php foreach ($activityLog as $log): ?>
                        <tr>
                            <td><?= esc($log['admin_name'] ?? 'System') ?></td>
                            <td><?= esc($log['action']) ?></td>
                            <td><?= esc($log['module']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No activity recorded.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== 7. QUICK ACTIONS ========== -->
<div class="card mb-4">
    <div class="card-header py-2">Quick Actions</div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('admin/complaints') ?>" class="btn btn-secondary btn-sm">📄 View All Complaints</a>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-info btn-sm">👤 Manage Admins</a>
            <a href="<?= base_url('admin/careers') ?>" class="btn btn-success btn-sm">📥 View Applications</a>
            <a href="<?= base_url('admin/logs') ?>" class="btn btn-dark btn-sm">📜 Full Activity Log</a>
        </div>
    </div>
</div>

<!-- ========== 8. SECURITY INFO ========== -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="fas fa-shield-alt me-1"></i> Security Info
            </div>
            <div class="card-body">
                <p><strong>Last login:</strong> <?= $lastLogin ?></p>
                <p><strong>Failed login attempts (your account):</strong> <?= $failedAttempts ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header py-2">
                <i class="fas fa-bell me-1"></i> Notifications
            </div>
            <div class="card-body">
                <?php if ($notificationCount > 0): ?>
                    <p>You have <?= $notificationCount ?> new notification(s).</p>
                    <a href="<?= base_url('admin/notifications') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                <?php else: ?>
                    <p class="text-muted mb-0">No new notifications.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>