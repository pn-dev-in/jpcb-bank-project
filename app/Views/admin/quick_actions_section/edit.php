<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Quick Actions Section (Heading & Subheading)</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/quick-actions-section/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subheading / Description</label>
                <textarea name="subheading" class="form-control" rows="3" required><?= old('subheading', $settings['subheading']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Section</button>
            <a href="<?= site_url('admin/quick-actions') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>