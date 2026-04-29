<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header"><h3 class="mb-0">Edit Admin User</h3></div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/users/update/'.$admin['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" value="<?= old('name', $admin['name']) ?>" required></div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= old('email', $admin['email']) ?>" required></div>
            <div class="mb-3"><label>Password (leave blank to keep current)</label><input type="password" name="password" class="form-control" placeholder="New password"></div>
            <div class="mb-3"><label>Role</label><select name="role_id" class="form-control"><?php foreach ($roles as $role): ?><option value="<?= $role['id'] ?>" <?= $admin['role_id'] == $role['id'] ? 'selected' : '' ?>><?= esc($role['name']) ?></option><?php endforeach; ?></select></div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>