<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Manage Trust Statistics Cards</h2>
<a href="<?= site_url('admin/trust-stats/create') ?>" class="btn btn-primary mb-3">+ Add New Stat Card</a>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Icon (Lucide)</th>
            <th>Value</th>
            <th>Label</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if(empty($stats)): ?>
        <tr><td colspan="7" class="text-center">No stat cards found. Create one.</td></tr>
    <?php else: ?>
        <?php foreach($stats as $stat): ?>
        <tr>
            <td><?= $stat['id'] ?></td>
            <td><?= esc($stat['icon']) ?></td>
            <td><?= esc($stat['value']) ?></td>
            <td><?= esc($stat['label']) ?></td>
            <td><?= $stat['sort_order'] ?></td>
            <td><?= $stat['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= site_url('admin/trust-stats/edit/'.$stat['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('admin/trust-stats/delete/'.$stat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this stat card?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<a href="<?= site_url('admin/trust-section/edit') ?>" class="btn btn-secondary mt-3">Edit the Trust Section Here</a>
<a href="<?= base_url('admin/trust-accessibility/edit') ?>" class="btn btn-secondary mt-3">Edit Accessibility Card</a>
<a href="<?= base_url('admin/trust-regulatory/edit') ?>" class="btn btn-secondary mt-3">Edit Regulatory Text</a>
<a href="<?= base_url('admin/trust-badges') ?>" class="btn btn-secondary mt-3">Edit Trust Badges</a>

<?= $this->endSection() ?>