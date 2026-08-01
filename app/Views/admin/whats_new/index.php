<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">What's New (Popup Notifications)</h3>
    <a href="<?= base_url('admin/whats-new/create') ?>" class="btn btn-primary btn-sm">+ Add Item</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= base_url($item['image']) ?>" style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px;" alt="<?= esc($item['title']) ?>">
                            <?php else: ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($item['title']) ?></td>
                        <td>
                            <span class="badge bg-<?= $item['type'] == 'announcement' ? 'info' : ($item['type'] == 'offer' ? 'success' : ($item['type'] == 'alert' ? 'danger' : 'secondary')) ?>">
                                <?= ucfirst($item['type']) ?>
                            </span>
                        </td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/whats-new/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/whats-new/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>