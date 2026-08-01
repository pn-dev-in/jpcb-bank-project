<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Social Media Links</h3>
    <a href="<?= site_url('admin/social-links/create') ?>" class="btn btn-primary btn-sm">+ Add Social Link</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>Icon</th>
                        <th>URL</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($links as $link): ?>
                    <tr>
                        <td><?= esc($link['platform']) ?></td>
                        <td><?= esc($link['icon']) ?></td>
                        <td><?= esc($link['url']) ?></td>
                        <td><?= $link['sort_order'] ?></td>
                        <td>
                            <span class="badge bg-<?= $link['status'] ? 'success' : 'secondary' ?>">
                                <?= $link['status'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url('admin/social-links/edit/'.$link['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= site_url('admin/social-links/delete/'.$link['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>