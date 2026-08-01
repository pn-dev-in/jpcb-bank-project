<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Quick Actions</h3>
    <a href="<?= site_url('admin/quick-actions/create') ?>" class="btn btn-primary btn-sm">+ Add New Quick Action</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
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
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Alert?</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quickActions as $action): ?>
                        <tr>
                            <td><?= $action['id'] ?></td>
                            <td>
                                <?php if (!empty($action['image']) && file_exists(FCPATH . $action['image'])): ?>
                                    <img src="<?= base_url($action['image']) ?>" width="50" height="50" class="rounded" style="object-fit: cover;">
                                <?php elseif (!empty($action['image'])): ?>
                                    <img src="<?= base_url($action['image']) ?>" width="50" height="50" class="rounded" style="object-fit: cover;" onerror="this.onerror=null; this.src='<?= base_url('assets/img/no-image.png') ?>';">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($action['title']) ?></td>
                            <td><?= esc($action['description']) ?></td>
                            <td><?= esc($action['link']) ?></td>
                            <td>
                                <span class="badge bg-<?= $action['is_alert'] ? 'danger' : 'secondary' ?>">
                                    <?= $action['is_alert'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $action['status'] ? 'success' : 'secondary' ?>">
                                    <?= $action['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/quick-actions/edit/' . $action['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= site_url('admin/quick-actions/delete/' . $action['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this quick action?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= site_url('admin/quick-actions-section/edit') ?>" class="btn btn-secondary btn-sm">Edit Quick Actions Section Heading/Subheading</a>
</div>

<?= $this->endSection() ?>