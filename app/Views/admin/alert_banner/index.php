<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php
$banner = $banner ??[];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Alert Banners</h3>
    <a href="<?= base_url('admin/alert-banner/create') ?>" class="btn btn-primary btn-sm">+ Add New Banner</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Popup?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($banners ?? []) as $banner): ?>
                        <tr>
                            <td>
                                <?php if (!empty($banner['image'])): ?>
                                    <img src="<?= base_url($banner['image']) ?>" style="width: 60px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($banner['title'] ?? '') ?></td>
                            <td>
                                <span class="badge bg-<?= ($banner['status'] ?? 0) ? 'success' : 'secondary' ?>">
                                    <?= ($banner['status'] ?? 0) ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($banner['is_popup'] ?? 0) ? 'info' : 'light' ?>">
                                    <?= ($banner['is_popup'] ?? 0) ? 'Popup' : 'Inline' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/alert-banner/edit/' . ($banner['id'] ?? 0)) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?= base_url('admin/alert-banner/delete/' . ($banner['id'] ?? 0)) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this banner?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>