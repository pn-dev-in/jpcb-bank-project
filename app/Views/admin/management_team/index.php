<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Management Team</h2>
<a href="<?= base_url('admin/management-team/create') ?>" class="btn btn-primary mb-3">+ Add New Member</a>

<table class="table table-bordered">
    <thead><tr><th>Name</th><th>Role</th><th>Department</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= esc($item['name']) ?></td>
        <td><?= esc($item['role']) ?></td>
        <td><?= esc($item['department']) ?></td>
        <td><?= $item['sort_order'] ?></td>
        <td><?= $item['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= base_url('admin/management-team/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= base_url('admin/management-team/delete/'.$item['id']) ?>" method="post" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>