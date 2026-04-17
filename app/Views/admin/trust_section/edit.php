<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit "Why Choose Us" Section (Heading & Subheading)</h2>

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

<form method="post" action="<?= site_url('admin/trust-section/update') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Heading</label>
        <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required>
    </div>

    <div class="form-group">
        <label>Subheading / Description</label>
        <textarea name="subheading" class="form-control" rows="3" required><?= old('subheading', $settings['subheading']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Section</button>
    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>