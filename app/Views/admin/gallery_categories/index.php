<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Gallery Categories</h2>
<a href="<?= base_url('admin/gallery-categories/create') ?>" class="btn btn-primary mb-3">+ Add New Category</a>

<table class="table table-bordered">
    <thead><tr><th>Name</th><th>Slug</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= esc($item['name']) ?></td>
        <td><?= esc($item['slug']) ?></td>
        <td><?= $item['sort_order'] ?></td>
        <td><?= $item['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= base_url('admin/gallery-categories/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= base_url('admin/gallery-categories/delete/'.$item['id']) ?>" method="post" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete category? This will also delete all items in this category.')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>