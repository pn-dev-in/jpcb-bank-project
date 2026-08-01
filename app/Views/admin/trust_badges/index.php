<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Trust Badges</h3>
    <a href="<?= site_url('admin/trust-badges/create') ?>" class="btn btn-primary btn-sm">+ Add New Badge</a>
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
                        <th>Label</th>
                        <th>Color Class</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($badges)): ?>
                        <tr><td colspan="7" class="text-center">No badges found. Create one.</td></tr>
                    <?php else: ?>
                        <?php foreach($badges as $badge): ?>
                        <tr>
                            <td><?= $badge['id'] ?></td>
                            <td><?= esc($badge['icon']) ?></td>
                            <td><?= esc($badge['label']) ?></td>
                            <td><?= esc($badge['color_class'] ?? '-') ?></td>
                            <td><?= $badge['sort_order'] ?></td>
                            <td>
                                <span class="badge bg-<?= $badge['status'] ? 'success' : 'secondary' ?>">
                                    <?= $badge['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/trust-badges/edit/'.$badge['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= site_url('admin/trust-badges/delete/'.$badge['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this badge?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>