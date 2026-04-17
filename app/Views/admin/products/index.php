<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2>Manage Products</h2>
<a href="<?= site_url('admin/products/create') ?>" class="btn">+ Add New Product</a>
<table>
    <thead>
        <tr><th>Name</th><th>Icon</th><th>Category</th><th>Link</th><th>Order</th><th>Status</th><th>Features</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach($products as $prod): ?>
        <tr>
            <td><?= esc($prod['name']) ?></td>
            <td><?= esc($prod['icon']) ?></td>
            <td><?= esc($prod['category'] ?? '-') ?></td>
            <td><?= esc($prod['href']) ?></td>
            <td><?= $prod['sort_order'] ?></td>
            <td><?= $prod['status'] ? 'Active' : 'Inactive' ?></td>
            <td><?= count($prod['features_list']) ?> features</td>
            <td>
                <a href="<?= site_url('admin/products/edit/'.$prod['id']) ?>">Edit</a>
                <a href="<?= site_url('admin/products/delete/'.$prod['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= site_url('admin/products-section/edit') ?>">Edit Products Section Heading/Subheading</a>
<?= $this->endSection() ?>