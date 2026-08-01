<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">🎫 Support Tickets</h3>
        <small class="text-muted">Manage technical support requests</small>
    </div>
    <a href="<?= base_url('admin/support-tickets/create') ?>" class="btn btn-success">
        <i class="fas fa-plus-circle"></i> New Ticket
    </a>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <?php
    $total = count($tickets ?? []);
    $open = count(array_filter($tickets ?? [], fn($t) => in_array($t['status'], ['open','in_progress'])));
    $closed = count(array_filter($tickets ?? [], fn($t) => in_array($t['status'], ['resolved','closed'])));
    ?>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #0d6efd;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold"><?= $total ?></h2>
                        <small class="text-muted">Total Tickets</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-ticket-alt text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold"><?= $open ?></h2>
                        <small class="text-muted">Active Tickets</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #198754;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold"><?= $closed ?></h2>
                        <small class="text-muted">Resolved</small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-check-circle text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 140px;">Ticket ID</th>
                        <?php if (session('role_id') == 1): ?>
                        <th style="width: 120px;">Created By</th>
                        <?php endif; ?>
                        <th>Subject</th>
                        <th style="width: 100px;">Priority</th>
                        <th style="width: 110px;">Status</th>
                        <th style="width: 90px;">Last Reply</th>
                        <th style="width: 100px;">Date</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td>
                            <span class="fw-bold text-primary"><?= esc($ticket['ticket_number']) ?></span>
                        </td>
                        <?php if (session('role_id') == 1): ?>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" 
                                     style="width: 32px; height: 32px;">
                                    <small class="fw-bold text-secondary">
                                        <?= strtoupper(substr($ticket['creator_name'] ?? 'U', 0, 1)) ?>
                                    </small>
                                </div>
                                <small><?= esc($ticket['creator_name'] ?? '—') ?></small>
                            </div>
                        </td>
                        <?php endif; ?>
                        <td>
                            <div class="text-truncate" style="max-width: 250px;">
                                <?= esc($ticket['subject']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill" 
                                  style="background:<?= getPriorityColor($ticket['priority']) ?>; font-size: 11px;">
                                <?= ucfirst($ticket['priority']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-<?= getStatusClass($ticket['status']) ?>" 
                                  style="font-size: 11px;">
                                <?= str_replace('_', ' ', ucfirst($ticket['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($ticket['last_reply_from']): ?>
                                <span class="badge bg-light text-dark border" style="font-size: 10px;">
                                    <?= strtoupper($ticket['last_reply_from']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td><small class="text-muted"><?= date('d M Y', strtotime($ticket['created_at'])) ?></small></td>
                        <td>
                            <a href="<?= base_url('admin/support-tickets/show/' . $ticket['id']) ?>" 
                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tickets)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fs-2 mb-2 d-block"></i>
                                <p>No tickets found</p>
                                <a href="<?= base_url('admin/support-tickets/create') ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create First Ticket
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
function getPriorityColor($p) {
    return match($p) {
        'low' => '#6c757d', 'medium' => '#0d6efd',
        'high' => '#fd7e14', 'critical' => '#dc3545',
        default => '#6c757d'
    };
}
function getStatusClass($s) {
    return match($s) {
        'open' => 'warning', 'in_progress' => 'info',
        'resolved' => 'success', 'closed' => 'secondary',
        default => 'light'
    };
}
?>

<?= $this->endSection() ?>