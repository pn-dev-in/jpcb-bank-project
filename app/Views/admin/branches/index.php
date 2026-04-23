<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Branches</h3>
    <a href="<?= base_url('admin/branches/create') ?>" class="btn btn-primary btn-sm">+ Add New Branch</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
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
                        <td>
                            <span class="badge bg-<?= $branch['has_atm'] ? 'success' : 'secondary' ?>">
                                <?= $branch['has_atm'] ? 'Yes' : 'No' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/branches/edit/'.$branch['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/branches/delete/'.$branch['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this branch?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>