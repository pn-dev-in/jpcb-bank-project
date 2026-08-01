<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <a href="<?= base_url('admin/support-tickets') ?>" class="btn btn-sm btn-light rounded-pill mb-2">
            <i class="fas fa-arrow-left me-1"></i> Back to Tickets
        </a>
        <h3 class="mb-1"><?= esc($ticket['subject']) ?></h3>
        <div class="d-flex gap-2 mt-2 flex-wrap">
            <span class="badge rounded-pill fs-6" style="background:<?= getPriorityColor($ticket['priority']) ?>;">
                #<?= esc($ticket['ticket_number']) ?>
            </span>
            <span class="badge rounded-pill" style="background:<?= getPriorityColor($ticket['priority']) ?>; font-size:12px;">
                <i class="fas fa-flag me-1"></i> <?= strtoupper($ticket['priority']) ?>
            </span>
            <span class="badge rounded-pill bg-<?= getStatusClass($ticket['status']) ?>" style="font-size:12px;">
                <i class="fas fa-<?= getStatusIcon($ticket['status']) ?> me-1"></i> 
                <?= str_replace('_', ' ', ucfirst($ticket['status'])) ?>
            </span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <?php if ($ticket['status'] != 'resolved' && $ticket['status'] != 'closed'): ?>
        <form method="post" action="<?= base_url('admin/support-tickets/change-status/' . $ticket['id']) ?>" class="d-inline">
            <?= csrf_field() ?>
            <input type="hidden" name="status" value="resolved">
            <button class="btn btn-success rounded-pill px-3">
                <i class="fas fa-check me-1"></i> Resolve
            </button>
        </form>
        <form method="post" action="<?= base_url('admin/support-tickets/change-status/' . $ticket['id']) ?>" class="d-inline">
            <?= csrf_field() ?>
            <input type="hidden" name="status" value="closed">
            <button class="btn btn-outline-secondary rounded-pill px-3" 
                    onclick="return confirm('Close this ticket?')">
                <i class="fas fa-times me-1"></i> Close
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4">
    <!-- Sidebar Info -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <i class="fas fa-info-circle text-primary me-2"></i>
                <strong>Ticket Information</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Created By</small>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                             style="width: 36px; height: 36px;">
                            <span class="fw-bold text-primary">
                                <?= strtoupper(substr($creator['name'] ?? 'U', 0, 1)) ?>
                            </span>
                        </div>
                        <div>
                            <strong><?= esc($creator['name'] ?? '—') ?></strong>
                            <br><small class="text-muted">JPCB Bank</small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-2">
                    <small class="text-muted"><i class="far fa-clock me-1"></i> Created</small>
                    <br><small><?= date('d M Y, h:i A', strtotime($ticket['created_at'])) ?></small>
                </div>
                <div>
                    <small class="text-muted"><i class="far fa-clock me-1"></i> Updated</small>
                    <br><small><?= $ticket['updated_at'] ? date('d M Y, h:i A', strtotime($ticket['updated_at'])) : '—' ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversation -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom d-flex align-items-center gap-2">
                <i class="fas fa-comments text-primary"></i>
                <strong>Conversation</strong>
            </div>
            <div class="card-body bg-light" style="max-height: 500px; overflow-y: auto;">
                <?php foreach ($messages as $msg): ?>
                <?php 
                $isJpcb = ($msg['sender_type'] == 'jpcb');
                $isSystem = ($msg['sender_type'] == 'system');
                ?>
                <div class="d-flex mb-3 <?= $isJpcb ? 'justify-content-end' : '' ?>">
                    <div class="p-3 rounded-3 shadow-sm" style="max-width: 80%;
                        <?= $isJpcb ? 'background: linear-gradient(135deg, #d1e7dd, #b7dfc5); margin-left: auto;' : 
                           ($isSystem ? 'background: #fff3cd; text-align: center; width: 100%; max-width: 100%;' : 
                            'background: #fff; border: 1px solid #e9ecef;') ?>">
                        <?php if (!$isSystem): ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle bg-<?= $isJpcb ? 'success' : 'primary' ?> bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 28px; height: 28px;">
                                    <small class="fw-bold text-<?= $isJpcb ? 'success' : 'primary' ?>">
                                        <?= strtoupper(substr($msg['sender_name'], 0, 1)) ?>
                                    </small>
                                </div>
                                <strong style="font-size: 13px;"><?= esc($msg['sender_name']) ?></strong>
                            </div>
                        <?php endif; ?>
                        <p class="mb-1" style="font-size: 14px;"><?= nl2br($msg['message']) ?></p>
                        <small class="text-muted" style="font-size: 11px;">
                            <i class="far fa-clock me-1"></i> <?= date('d M, h:i A', strtotime($msg['created_at'])) ?>
                        </small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($ticket['status'] != 'closed'): ?>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <i class="fas fa-reply text-primary me-2"></i>
                <strong>Reply to Ticket</strong>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/support-tickets/reply/' . $ticket['id']) ?>">
                    <?= csrf_field() ?>
                    <textarea name="message" class="form-control rounded-3 mb-3" rows="4" required 
                              placeholder="Type your reply here..."></textarea>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-paper-plane me-2"></i> Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
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
function getStatusIcon($s) {
    return match($s) {
        'open' => 'folder-open', 'in_progress' => 'spinner',
        'resolved' => 'check-circle', 'closed' => 'times-circle',
        default => 'circle'
    };
}
?>

<?= $this->endSection() ?>