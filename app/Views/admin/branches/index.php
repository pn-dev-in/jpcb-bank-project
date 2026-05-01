<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php
// Ensure $branches is always an array
$branches = $branches ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0">Branches</h3>
    <div>
        <?php if (has_permission('branches.import')): ?>
        <a href="<?= base_url('admin/branches/import') ?>" class="btn btn-info btn-sm">📂 Bulk Import Branches</a> <?php endif; ?>
        <a href="<?= base_url('admin/branches/create') ?>" class="btn btn-primary btn-sm">+ Add New Branch</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>City</th>
                        <th>IFSC</th>
                        <th>MICR</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branches as $branch): ?>
                        <?php if (!is_array($branch)) continue; ?>
                        <tr>
                            <td><?= esc((string)($branch['branch_name'] ?? '')) ?></td>
                            <td><?= esc((string)($branch['city'] ?? '')) ?></td>
                            <td><?= esc((string)($branch['ifsc'] ?? '-')) ?></td>
                            <td><?= esc((string)($branch['micr'] ?? '-')) ?></td>
                            <td><?= esc((string)($branch['phone'] ?? '')) ?></td>
                            <td>
                                <?php $status = (int)($branch['status'] ?? 1); ?>
                                <span class="badge bg-<?= $status ? 'success' : 'secondary' ?>">
                                    <?= $status ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/branches/edit/' . ($branch['id'] ?? 0)) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?= base_url('admin/branches/delete/' . ($branch['id'] ?? 0)) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
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