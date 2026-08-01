<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Download Categories</h3>
    <a href="<?= base_url('admin/download-categories/create') ?>" class="btn btn-primary">+ Add Category</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width: 120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= esc($cat['name']) ?></td>
                        <td><?= esc($cat['slug']) ?></td>
                        <td><?= $cat['sort_order'] ?></td>
                        <td><span class="badge bg-<?= $cat['status'] ? 'success' : 'secondary' ?>"><?= $cat['status'] ? 'Active' : 'Inactive' ?></span></td>
                        <td>
                            <a href="<?= base_url('admin/download-categories/edit/' . $cat['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/download-categories/delete/' . $cat['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
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