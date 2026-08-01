<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">ATM Guidelines</h3>
    <a href="<?= base_url('admin/atm-guidelines/create') ?>" class="btn btn-primary btn-sm">+ Add Guideline</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Guideline</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item['guideline']) ?></td>
                        <td><?= $item['sort_order'] ?></td>
                        <td><span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>"><?= $item['status'] ? 'Active' : 'Inactive' ?></span></td>
                        <td>
                            <a href="<?= base_url('admin/atm-guidelines/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/atm-guidelines/delete/' . $item['id']) ?>" method="post" class="d-inline">
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