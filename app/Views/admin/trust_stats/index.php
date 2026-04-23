<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Trust Statistics Cards</h3>
    <a href="<?= site_url('admin/trust-stats/create') ?>" class="btn btn-primary btn-sm">+ Add New Stat Card</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon (Lucide)</th>
                        <th>Value</th>
                        <th>Label</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($stats)): ?>
                        <tr><td colspan="7" class="text-center">No stat cards found. Create one.</td></tr>
                    <?php else: ?>
                        <?php foreach($stats as $stat): ?>
                        <tr>
                            <td><?= $stat['id'] ?></td>
                            <td><?= esc($stat['icon']) ?></td>
                            <td><?= esc($stat['value']) ?></td>
                            <td><?= esc($stat['label']) ?></td>
                            <td><?= $stat['sort_order'] ?></td>
                            <td>
                                <span class="badge bg-<?= $stat['status'] ? 'success' : 'secondary' ?>">
                                    <?= $stat['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/trust-stats/edit/'.$stat['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= site_url('admin/trust-stats/delete/'.$stat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this stat card?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 d-flex flex-wrap gap-2">
    <a href="<?= site_url('admin/trust-section/edit') ?>" class="btn btn-secondary btn-sm">Edit Trust Section Heading</a>
    <a href="<?= base_url('admin/trust-accessibility/edit') ?>" class="btn btn-secondary btn-sm">Edit Accessibility Card</a>
    <a href="<?= base_url('admin/trust-regulatory/edit') ?>" class="btn btn-secondary btn-sm">Edit Regulatory Text</a>
    <a href="<?= base_url('admin/trust-badges') ?>" class="btn btn-secondary btn-sm">Manage Trust Badges</a>
</div>

<?= $this->endSection() ?>