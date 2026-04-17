<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Regulatory Text & Disclaimer</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach(session()->getFlashdata('errors') as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/trust-regulatory/update') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Regulatory Description</label>
        <textarea name="description" class="form-control" rows="4" required><?= old('description', $settings['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label>Disclaimer (small text at bottom)</label>
        <input type="text" name="disclaimer" class="form-control" value="<?= old('disclaimer', $settings['disclaimer']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>