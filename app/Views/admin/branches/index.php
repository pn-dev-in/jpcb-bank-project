<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Branches</h2>

<a href="<?= base_url('admin/branches/create') ?>" class="btn btn-primary">Add New Branch</a>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>City</th>
            <th>IFSC</th>
            <th>Phone</th>
            <th>ATM</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($branches as $branch): ?>
        <tr>
            <td><?= esc($branch['branch_name']) ?></td>
            <td><?= esc($branch['city']) ?></td>
            <td><?= esc($branch['ifsc'] ?? '-') ?></td>
            <td><?= esc($branch['phone']) ?></td>
            <td><?= $branch['has_atm'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="<?= base_url('admin/branches/edit/'.$branch['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="<?= base_url('admin/branches/delete/'.$branch['id']) ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this branch?')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>