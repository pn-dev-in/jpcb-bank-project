<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Roles</h3>
    <a href="<?= base_url('admin/roles/create') ?>" class="btn btn-primary btn-sm">+ Create Role</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?= esc($role['name']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/roles/assign/'.$role['id']) ?>" class="btn btn-sm btn-primary">Assign Permissions</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>