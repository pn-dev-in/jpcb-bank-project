<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Notices</h2>
    <a href="<?= base_url('admin/notices/create') ?>" class="btn btn-primary btn-sm">+ Add Notice</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notices)): ?>
                        <?php foreach ($notices as $n): ?>
                            <tr>
                                <td><?= esc($n['id']) ?></td>
                                <td><?= esc($n['title']) ?></td>
                                <td><?= esc(substr($n['description'] ?? '', 0, 60)) ?>...</td>
                                <td>
                                    <span class="badge bg-<?=
                                                            $n['type'] == 'Announcement' ? 'info' : ($n['type'] == 'Alert' ? 'danger' : ($n['type'] == 'Holiday' ? 'warning' : 'secondary'))
                                                            ?>"><?= esc($n['type']) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($n['date'])) ?></td>
                                <td><?= $n['sort_order'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $n['status'] ? 'success' : 'secondary' ?>">
                                        <?= $n['status'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/notices/edit/' . $n['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?= base_url('admin/notices/delete/' . $n['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No notices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>