<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Create Role</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/roles/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g., Manager, Editor, Viewer" required>
                <small class="text-muted d-block">Enter a unique role name.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>