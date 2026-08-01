<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header"><h3 class="mb-0">Edit Role</h3></div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/roles/update/'.$role['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3"><label>Role Name</label><input type="text" name="name" class="form-control" value="<?= old('name', $role['name']) ?>" required></div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>