<?= $this->extend('jbb/layout/main') ?>
<?= $this->section('content') ?>

<!-- Back Button -->
<a href="<?= base_url('jbb/tickets') ?>" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="fas fa-arrow-left"></i> Back to Tickets
</a>

<div class="row">
    <!-- Ticket Info Sidebar -->
    <div class="col-md-4">
        <div class="jbb-card">
            <div class="jbb-card-header">
                <i class="fas fa-info-circle text-primary"></i> Ticket Details
            </div>
            <div class="jbb-card-body">
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted">Ticket</td><td><strong><?= esc($ticket['jpcb_ticket_number']) ?></strong></td></tr>
                    <tr><td class="text-muted">Priority</td>
                        <td><span class="priority-dot" style="background:<?= getPriorityColor($ticket['priority']) ?>;"></span>
                            <?= ucfirst($ticket['priority']) ?></td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge-status bg-<?= getStatusClass($ticket['status']) ?>">
                            <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?></span></td></tr>
                    <tr><td class="text-muted">Created</td><td><small><?= $ticket['created_at'] ?></small></td></tr>
                </table>
            </div>
        </div>
        
        <!-- Status Change Buttons -->
        <?php if ($ticket['status'] != 'closed'): ?>
        <div class="jbb-card">
            <div class="jbb-card-header">
                <i class="fas fa-cog text-primary"></i> Actions
            </div>
            <div class="jbb-card-body">
                <form method="post" action="<?= base_url('jbb/tickets/change-status/'.$ticket['id']) ?>" class="mb-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="in_progress">
                    <button class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-spinner"></i> Mark In Progress
                    </button>
                </form>
                <form method="post" action="<?= base_url('jbb/tickets/change-status/'.$ticket['id']) ?>" class="mb-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="resolved">
                    <button class="btn btn-success w-100 mb-2">
                        <i class="fas fa-check"></i> Resolve
                    </button>
                </form>
                <form method="post" action="<?= base_url('jbb/tickets/change-status/'.$ticket['id']) ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="closed">
                    <button class="btn btn-outline-secondary w-100" onclick="return confirm('Close this ticket?')">
                        <i class="fas fa-times"></i> Close Ticket
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Conversation -->
    <div class="col-md-8">
        <div class="jbb-card" style="height: 400px; overflow-y: auto;" id="chatBox">
            <div class="jbb-card-header">
                <i class="fas fa-comments text-primary"></i> Conversation
            </div>
            <div class="jbb-card-body">
                <?php foreach ($messages as $msg): ?>
                <div class="chat-message <?= $msg['sender_type'] ?>">
                    <strong style="font-size:12px;"><?= esc($msg['sender_name']) ?></strong>
                    <small class="text-muted ms-2" style="font-size:11px;"><?= $msg['created_at'] ?></small>
                    <p class="mb-0 mt-1"><?= nl2br($msg['message']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Reply Form -->
        <?php if ($ticket['status'] != 'closed'): ?>
        <div class="jbb-card mt-3">
            <div class="jbb-card-header">
                <i class="fas fa-reply text-primary"></i> Reply
            </div>
            <div class="jbb-card-body">
                <form method="post" action="<?= base_url('jbb/tickets/reply/'.$ticket['id']) ?>">
                    <?= csrf_field() ?>
                    <textarea name="message" class="form-control mb-3" rows="3" required 
                              placeholder="Type your reply..."></textarea>
                    <button class="btn-jbb-primary">
                        <i class="fas fa-paper-plane"></i> Send Reply
                    </button>
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
?>

<?= $this->endSection() ?>