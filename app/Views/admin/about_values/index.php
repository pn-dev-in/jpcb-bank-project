<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>About Values</h2>
<a href="<?= base_url('admin/about-values/create') ?>" class="btn btn-primary mb-3">+ Add New Value</a>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= esc($item['icon']) ?></td>
        <td><?= esc($item['title']) ?></td>
        <td><?= esc(substr($item['description'], 0, 50)) ?>...</td>
        <td><?= $item['sort_order'] ?></td>
        <td><?= $item['status'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <a href="<?= base_url('admin/about-values/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?= base_url('admin/about-values/delete/'.$item['id']) ?>" method="post" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>