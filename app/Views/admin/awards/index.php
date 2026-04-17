<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Awards & Recognition</h2>
<a href="<?= base_url('admin/awards/create') ?>" class="btn btn-primary mb-3">+ Add New Award</a>

<table class="table table-bordered">
    <thead><tr><th>Year</th><th>Title</th><th>Organization</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= esc($item['year']) ?></td>
        <td><?= esc($item['title']) ?></td>
        <td><?= esc($item['organization']) ?></td>
        <td><?= $item['sort_order'] ?></td>
        <td><?= $item['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= base_url('admin/awards/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= base_url('admin/awards/delete/'.$item['id']) ?>" method="post" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>