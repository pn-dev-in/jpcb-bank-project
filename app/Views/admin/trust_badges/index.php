<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Manage Trust Badges</h2>
<a href="<?= site_url('admin/trust-badges/create') ?>" class="btn btn-primary mb-3">+ Add New Badge</a>

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
            <th>Label</th>
            <th>Color Class</th>
            <th>Sort Order</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if(empty($badges)): ?>
        <tr><td colspan="7" class="text-center">No badges found. Create one.</td></tr>
    <?php else: ?>
        <?php foreach($badges as $badge): ?>
        <tr>
            <td><?= $badge['id'] ?></td>
            <td><?= esc($badge['icon']) ?></td>
            <td><?= esc($badge['label']) ?></td>
            <td><?= esc($badge['color_class'] ?? '-') ?></td>
            <td><?= $badge['sort_order'] ?></td>
            <td><?= $badge['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= site_url('admin/trust-badges/edit/'.$badge['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('admin/trust-badges/delete/'.$badge['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this badge?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>