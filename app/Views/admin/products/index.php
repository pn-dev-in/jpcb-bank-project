<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Products</h3>
    <a href="<?= site_url('admin/products/create') ?>" class="btn btn-primary btn-sm">+ Add New Product</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Category</th>
                        <th>Link</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Features</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $prod): ?>
                    <tr>
                        <td><?= esc($prod['name']) ?></td>
                        <td><?= esc($prod['icon']) ?></td>
                        <td><?= esc($prod['category'] ?? '-') ?></td>
                        <td><?= esc($prod['href']) ?></td>
                        <td><?= $prod['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $prod['status'] ? 'success' : 'secondary' ?>">
                                <?= $prod['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td><?= count($prod['features_list']) ?> features</td>
                        <td>
                            <a href="<?= site_url('admin/products/edit/'.$prod['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('admin/products/delete/'.$prod['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= site_url('admin/products-section/edit') ?>" class="btn btn-secondary btn-sm">Edit Products Section Heading/Subheading</a>
</div>

<?= $this->endSection() ?>