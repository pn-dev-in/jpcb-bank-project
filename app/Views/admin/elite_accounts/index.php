<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Elite Accounts (Premium Banking)</h3>
    <a href="<?= base_url('admin/elite-accounts/create') ?>" class="btn btn-primary btn-sm">+ Add Elite Account</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Heading</th>
                        <th>Badge Text</th>
                        <th>Frontend</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= esc($item['heading']) ?></td>
                        <td><?= esc($item['badge_text'] ?? 'Premium Banking') ?></td>
                        <td>
                            <span class="badge bg-<?= ($item['show_in_frontend'] ?? 1) ? 'info' : 'secondary' ?>">
                                <?= ($item['show_in_frontend'] ?? 1) ? 'Show' : 'Hidden' ?>
                            </span>
                        </td>
                        <td><?= $item['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $item['status'] ? 'success' : 'secondary' ?>">
                                <?= $item['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/elite-accounts/edit/'.$item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= base_url('admin/elite-accounts/delete/'.$item['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this elite account?')">Delete</button>
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