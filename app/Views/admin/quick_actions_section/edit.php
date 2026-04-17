<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2>Edit Quick Actions Section (Heading & Subheading)</h2>
<?php if(session()->getFlashdata('message')): ?>
    <div class="alert success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<form method="post" action="<?= site_url('admin/quick-actions-section/update') ?>">
    <?= csrf_field() ?>
    <label>Heading</label>
    <input type="text" name="heading" value="<?= old('heading', $settings['heading']) ?>" required>

    <label>Subheading / Description</label>
    <textarea name="subheading" rows="3" required><?= old('subheading', $settings['subheading']) ?></textarea>

    <button type="submit">Update Section</button>
</form>
<?= $this->endSection() ?>