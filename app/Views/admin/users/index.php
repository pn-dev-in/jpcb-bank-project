<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Admin Users</h3>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm">
        + Add Admin
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($admins)): ?>
                        <?php foreach ($admins as $a): ?>
                            <tr>
                                <td><?= esc($a['name']) ?></td>
                                <td><?= esc($a['employee_id'] ?? '-') ?></td>
                                <td><?= esc($a['email']) ?></td>
                                <td><?= esc($a['role_name']) ?></td>
                                <td>
                                    <!-- View -->
                                    <a href="<?= base_url('admin/users/view/' . $a['id']) ?>"
                                       class="btn btn-info btn-sm">
                                        View
                                    </a>

                                    <!-- Edit -->
                                    <a href="<?= base_url('admin/users/edit/' . $a['id']) ?>"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="<?= base_url('admin/users/delete/' . $a['id']) ?>"
                                          method="post"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this admin?');">

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
                            <td colspan="4" class="text-center py-3">
                                No admins found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>