<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">RBI Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/rbi-settings/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Ombudsman Introduction Text</label>
                <textarea name="ombudsman_intro" class="form-control" rows="5"><?= esc($settings['ombudsman_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the Banking Ombudsman page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Booklet Introduction Text</label>
                <textarea name="booklet_intro" class="form-control" rows="5"><?= esc($settings['booklet_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the RBI Booklet page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Integrated Ombudsman Introduction Text</label>
                <textarea name="integrated_ombudsman_intro" class="form-control" rows="5"><?= esc($settings['integrated_ombudsman_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the Integrated Ombudsman page.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/rbi-topics') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>