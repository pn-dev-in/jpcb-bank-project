<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Career Applications</h3>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Resume</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applications)): ?>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= esc($app['name']) ?></td>
                            <td><?= esc($app['email']) ?></td>
                            <td><?= esc($app['phone']) ?></td>
                            <td>
                                <a href="<?= base_url($app['resume']) ?>" target="_blank" class="btn btn-sm btn-primary">Download</a>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($app['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/careers/delete/'.$app['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this application?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No applications found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>