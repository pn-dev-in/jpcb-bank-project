<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Manage Grievance Steps</h3>
    <a href="<?= site_url('admin/grievance-steps/create') ?>" class="btn btn-primary btn-sm">+ Add New Step</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Step</th>
                        <th>Title</th>
                        <th>Timeline</th>
                        <th>Action</th>
                        <th>External</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($steps as $step): ?>
                        <tr>
                            <td><?= $step['step'] ?></td>
                            <td><?= esc($step['title']) ?></td>
                            <td><?= esc($step['timeline']) ?></td>
                            <td><?= esc($step['action']) ?></td>
                            <td>
                                <span class="badge bg-<?= $step['external'] ? 'info' : 'secondary' ?>">
                                    <?= $step['external'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $step['status'] ? 'success' : 'secondary' ?>">
                                    <?= $step['status'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/grievance-steps/edit/' . $step['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= site_url('admin/grievance-steps/delete/' . $step['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= site_url('admin/grievance-section/edit') ?>" class="btn btn-secondary btn-sm">Edit Grievance Redressal Section Heading/Subheading</a>
</div>

<?= $this->endSection() ?>