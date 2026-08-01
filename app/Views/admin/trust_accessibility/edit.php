<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Accessibility Card</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <p class="mb-0"><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/trust-accessibility/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= old('description', $settings['description']) ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="<?= old('button_text', $settings['button_text']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Link (relative URL, e.g., accessibility)</label>
                    <input type="text" name="button_link" class="form-control" value="<?= old('button_link', $settings['button_link']) ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= site_url('admin/trust-stats') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>