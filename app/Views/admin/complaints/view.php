<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php if (empty($complaint) || !is_array($complaint)): ?>
    <div class="alert alert-danger">Complaint not found.</div>
    <a href="<?= base_url('admin/complaints') ?>" class="btn btn-secondary">Back to List</a>
<?php else: ?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Complaint Details</h5>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Ticket:</div>
            <div class="col-md-9"><?= esc($complaint['ticket_number'] ?? 'N/A') ?></div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Name:</div>
            <div class="col-md-9"><?= esc($complaint['name'] ?? '') ?></div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Email:</div>
            <div class="col-md-9"><?= esc($complaint['email'] ?? '') ?></div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Phone:</div>
            <div class="col-md-9"><?= esc($complaint['phone'] ?? '') ?></div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Message:</div>
            <div class="col-md-9"><?= nl2br(esc($complaint['message'] ?? '')) ?></div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3 fw-bold">Status:</div>
            <div class="col-md-9">
                <span class="badge bg-<?= ($complaint['status'] ?? '') == 'Pending' ? 'warning' : 'success' ?>">
                    <?= esc($complaint['status'] ?? 'Pending') ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Update Complaint</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/complaints/update/'.$complaint['id']) ?>">
            <?= csrf_field() ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Update Status:</label>
                    <select name="status" class="form-control">
                        <option value="Pending" <?= (($complaint['status'] ?? '') == 'Pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="Resolved" <?= (($complaint['status'] ?? '') == 'Resolved') ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Assign To:</label>
                    <select name="assigned_to" class="form-control">
                        <option value="">Unassigned</option>
                        <?php 
                        $db = \Config\Database::connect();
                        $admins = $db->table('admins')->get()->getResultArray();
                        foreach($admins as $a): ?>
                            <option value="<?= $a['id'] ?>" <?= (($complaint['assigned_to'] ?? '') == $a['id']) ? 'selected' : '' ?>>
                                <?= esc($a['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Comment (internal note)</label>
                <textarea name="comment" class="form-control" rows="3" placeholder="Add a note about this complaint..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Complaint</button>
            <a href="<?= base_url('admin/complaints') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Status History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead>
                    <tr><th>Status</th><th>Comment</th><th>Updated By</th><th>Time</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $db = \Config\Database::connect();
                    $logs = $db->table('complaint_logs')
                               ->where('complaint_id', $complaint['id'])
                               ->orderBy('id', 'DESC')
                               ->get()
                               ->getResultArray();
                    ?>
                    <?php if (!empty($logs)): ?>
                        <?php foreach($logs as $log): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= esc($log['status']) ?></span></td>
                                <td><?= esc($log['comment']) ?></td>
                                <td><?= esc($log['updated_by'] ?? 'System') ?></td>
                                <td><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No history found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>