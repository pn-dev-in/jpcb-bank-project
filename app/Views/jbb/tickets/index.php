<?= $this->extend('jbb/layout/main') ?>
<?= $this->section('content') ?>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <?php
    $total = count($tickets ?? []);
    $open = count(array_filter($tickets ?? [], fn($t) => $t['status'] === 'open'));
    $closed = count(array_filter($tickets ?? [], fn($t) => $t['status'] === 'closed'));
    ?>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
            <i class="fas fa-ticket-alt stat-icon"></i>
            <h3 class="mb-0"><?= $total ?></h3>
            <small>Total Tickets</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
            <i class="fas fa-clock stat-icon"></i>
            <h3 class="mb-0"><?= $open ?></h3>
            <small>Open Tickets</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #198754, #146c43);">
            <i class="fas fa-check-circle stat-icon"></i>
            <h3 class="mb-0"><?= $closed ?></h3>
            <small>Resolved / Closed</small>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="jbb-card">
    <div class="jbb-card-header">
        <i class="fas fa-list text-primary"></i> Support Tickets
    </div>
    <div class="jbb-card-body p-0">
        <div class="table-responsive">
            <table class="jbb-table mb-0">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $t): ?>
                    <tr>
                        <td><strong><?= esc($t['jpcb_ticket_number']) ?></strong></td>
                        <td><?= esc($t['subject']) ?></td>
                        <td>
                            <span class="priority-dot" style="background:<?= getPriorityColor($t['priority']) ?>;"></span>
                            <?= ucfirst($t['priority']) ?>
                        </td>
                        <td>
                            <span class="badge-status bg-<?= getStatusClass($t['status']) ?>">
                                <?= ucfirst(str_replace('_', ' ', $t['status'])) ?>
                            </span>
                        </td>
                        <td><small><?= date('d M Y', strtotime($t['created_at'])) ?></small></td>
                        <td>
                            <a href="<?= base_url('jbb/tickets/show/'.$t['id']) ?>" 
                               class="btn-jbb-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tickets)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">No tickets found.</td></tr>
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