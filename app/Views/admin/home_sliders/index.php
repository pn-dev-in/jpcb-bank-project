<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Homepage Sliders</h3>
    <a href="<?= base_url('admin/home-sliders/create') ?>" class="btn btn-primary btn-sm">+ Add Slider</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px">ID</th>
                        <th style="width: 100px">Image</th>
                        <th>Title</th>
                        <th>Button Text</th>
                        <th style="width: 80px">Order</th>
                        <th style="width: 80px">Status</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= base_url($item['image']) ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;" alt="<?= esc($item['title']) ?>">
                            <?php else: ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($item['title']) ?></td>
                        <td><?= esc($item['button_text']) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/home-sliders/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/home-sliders/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slider? The image file will also be deleted.')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>