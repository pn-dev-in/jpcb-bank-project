<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Roles</h3>
    <a href="<?= base_url('admin/roles/create') ?>" class="btn btn-primary btn-sm">
        + Create Role
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th width="280">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?= esc($role['name']) ?></td>
                            <td>

                                <!-- Assign Permissions -->
                                <a href="<?= base_url('admin/roles/assign/'.$role['id']) ?>"
                                   class="btn btn-primary btn-sm">
                                    Assign
                                </a>

                                <!-- Edit -->
                                <a href="<?= base_url('admin/roles/edit/'.$role['id']) ?>"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form action="<?= base_url('admin/roles/delete/'.$role['id']) ?>"
                                      method="post"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Delete this role?');">

                                    <?= csrf_field() ?>

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center py-3">
                                No roles found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>