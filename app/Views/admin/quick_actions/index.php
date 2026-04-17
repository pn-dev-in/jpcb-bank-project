<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Manage Quick Actions</h2>
<a href="<?= site_url('admin/quick-actions/create') ?>" class="btn btn-primary mb-3">+ Add New Quick Action</a>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Icon</th>
            <th>Link</th>
            <th>Alert?</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($quickActions as $action): ?>
        <tr>
            <td><?= $action['id'] ?></td>
            <td><?= esc($action['title']) ?></td>
            <td><?= esc($action['description']) ?></td>
            <td><?= esc($action['icon']) ?></td>
            <td><?= esc($action['link']) ?></td>
            <td><?= $action['is_alert'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="<?= site_url('admin/quick-actions/edit/'.$action['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('admin/quick-actions/delete/'.$action['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this quick action?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= site_url('admin/quick-actions-section/edit') ?>" class="btn btn-secondary mt-3">Edit Quick Actions Section Heading/Subheading</a>

<?= $this->endSection() ?>