<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">DEAF Deposits (Unclaimed Deposits)</h3>
    <div>
        <a href="<?= base_url('admin/deaf-deposits/import') ?>" class="btn btn-success btn-sm">
            <i class="ti ti-upload"></i> Import Excel/CSV
        </a>
        <a href="<?= base_url('admin/deaf-deposits/create') ?>" class="btn btn-primary btn-sm">
            <i class="ti ti-plus"></i> Add Record
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>UDRN</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['sr_no'] ?></td>
                            <td><?= esc($item['udrn']) ?></td>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= esc(substr($item['address'], 0, 60)) ?>...</td>
                            <td><?= $item['sort_order'] ?></td>
                            <td>
                                <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                    <?= $item['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/deaf-deposits/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <a href="<?= base_url('admin/deaf-deposits/delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">No DEAF deposit records found. You can import or add records.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>