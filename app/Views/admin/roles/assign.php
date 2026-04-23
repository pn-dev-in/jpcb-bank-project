<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Assign Permissions to <?= esc($role['name']) ?></h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/roles/save/'.$role['id']) ?>">
            <?= csrf_field() ?>
            <div class="row">
                <?php foreach ($permissions as $p): ?>
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="<?= $p['id'] ?>" class="form-check-input" id="perm_<?= $p['id'] ?>">
                            <label class="form-check-label" for="perm_<?= $p['id'] ?>"><?= esc($p['name']) ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Permissions</button>
            <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>