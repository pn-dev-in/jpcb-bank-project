<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Downloads (Documents)</h3>
    <a href="<?= base_url('admin/downloads/create') ?>" class="btn btn-primary btn-sm">+ Upload New Document</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Thumb</th>
                        <th>Category</th>
                        <th>File Type</th>
                        <th>Size</th>
                        <th>Updated</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['title']) ?></td>
                        <td>
    <?php if (!empty($item['thumbnail'])): ?>
        <img src="<?= base_url($item['thumbnail']) ?>" alt="thumb"
             style="height:36px;width:auto;border-radius:4px;">
    <?php else: ?>
        <span class="text-muted">—</span>
    <?php endif; ?>
</td>
                        <td><?= esc($item['category_name'] ?? 'Uncategorized') ?></td>
                        <td><?= esc($item['file_type']) ?></td>
                        <td><?= number_format($item['file_size'] / 1024, 1) ?> KB</td>
                        <td><?= date('d M Y', strtotime($item['updated_date'])) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/downloads/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/downloads/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this document?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= site_url('admin/download-categories') ?>" class="btn btn-secondary btn-sm">Edit Downloads Categories</a>
</div>
<?= $this->endSection() ?>