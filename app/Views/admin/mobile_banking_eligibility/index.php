<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Mobile Banking Eligibility Rules</h3>
    <a href="<?= base_url('admin/mobile-banking-eligibility/create') ?>" class="btn btn-primary btn-sm">+ Add Rule</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Account Type</th>
                        <th>Constitution</th>
                        <th>Mode of Operation</th>
                        <th>Eligible</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['account_type']) ?></td>
                        <td><?= esc($item['constitution']) ?></td>
                        <td><?= esc($item['mode_of_operation']) ?></td>
                        <td>
                            <?php if ($item['eligible']): ?>
                                <span class="badge bg-success">The Account Holder</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Not Eligible</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $item['sort_order'] ?></td>
                        <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                        <td>
                            <a href="<?= base_url('admin/mobile-banking-eligibility/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/mobile-banking-eligibility/delete/' . $item['id']) ?>" method="post" class="d-inline">
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