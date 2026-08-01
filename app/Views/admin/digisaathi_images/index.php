<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">DigiSaathi Image Manager</h3>
    <a href="<?= base_url('admin/digisaathi-images/create') ?>" class="btn btn-primary btn-sm">+ Add New Image</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Image</th>
                        <th>Image Path</th>
                        <th>Alt Text</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <span class="badge bg-info">
                                <?= ucfirst(esc($item['section'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($item['image_path']) && file_exists($item['image_path'])): ?>
                                <img src="<?= base_url($item['image_path']) ?>" width="50" height="50" class="rounded" style="object-fit: cover;">
                            <?php else: ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <code><?= esc($item['image_path']) ?></code>
                        </td>
                        <td><?= esc($item['alt_text']) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/digisaathi-images/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/digisaathi-images/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this image?')">Delete</button>
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