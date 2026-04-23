<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Regulatory Text & Disclaimer</h3>
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

        <form method="post" action="<?= site_url('admin/trust-regulatory/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Regulatory Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= old('description', $settings['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Disclaimer (small text at bottom)</label>
                <input type="text" name="disclaimer" class="form-control" value="<?= old('disclaimer', $settings['disclaimer']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= site_url('admin/trust-stats') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>