<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<?php
// At the top of the view, after $this->section('content')
$modules = $modules ?? [];
$module_filter = $module_filter ?? '';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Activity Logs</h3>
    </div>
    <div class="card-body">
        <!-- Filter form -->
        <form method="get" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search (admin, action, module, IP)" value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-2">
                <select name="module" class="form-select">
                    <option value="">All Modules</option>
                    <?php foreach ($modules as $mod): ?>
                        <option value="<?= esc((string)($mod['module'] ?? '')) ?>" <?= ((string)($module_filter ?? '') == (string)($mod['module'] ?? '')) ? 'selected' : '' ?>>
                            <?= esc((string)($mod['module'] ?? '')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="<?= esc($from_date ?? '') ?>" placeholder="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" class="form-control" value="<?= esc($to_date ?? '') ?>" placeholder="To date">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="<?= base_url('admin/logs') ?>" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Record ID</th>
                        <th>IP Address</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No activity logs found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= esc((string)($log['admin_name'] ?? 'Unknown')) ?></td>
                                <td><?= esc((string)($log['action'] ?? '')) ?></td>
                                <td><?= esc((string)($log['module'] ?? '')) ?></td>
                                <td><?= esc((string)($log['record_id'] ?? '')) ?></td>
                                <td><?= esc((string)($log['ip_address'] ?? '')) ?></td>
                                <td><?= date('d M Y H:i:s', strtotime($log['created_at'] ?? 'now')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pager) && is_object($pager) && method_exists($pager, 'links')): ?>
            <?= $pager->links() ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>