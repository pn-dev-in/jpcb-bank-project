<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Gallery Items</h2>
<a href="<?= base_url('admin/gallery-items/create') ?>" class="btn btn-primary mb-3">+ Add New Item</a>

<table class="table table-bordered">
    <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td>
            <?php if ($item['image']): ?>
                <img src="<?= base_url($item['image']) ?>" style="width: 60px; height: 60px; object-fit: cover;">
            <?php else: ?>
                <i data-lucide="image" class="w-8 h-8"></i>
            <?php endif; ?>
        </td>
        <td><?= esc($item['title']) ?></td>
        <td><?= esc($item['category_name']) ?></td>
        <td><?= $item['sort_order'] ?></td>
        <td><?= $item['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= base_url('admin/gallery-items/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= base_url('admin/gallery-items/delete/'.$item['id']) ?>" method="post" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>