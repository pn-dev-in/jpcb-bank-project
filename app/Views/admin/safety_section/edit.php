<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2>Edit Safety Section (Fraud Awareness)</h2>
<?php if(session()->getFlashdata('message')): ?>
    <div class="alert success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<form method="post" action="<?= site_url('admin/safety-section/update') ?>">
    <?= csrf_field() ?>
    
    <label>Heading</label>
    <input type="text" name="heading" value="<?= old('heading', $settings['heading']) ?>" required>

    <label>Warning Text (highlighted box)</label>
    <textarea name="warning_text" rows="3" required><?= old('warning_text', $settings['warning_text']) ?></textarea>

    <label>Description (main paragraph)</label>
    <textarea name="description" rows="4" required><?= old('description', $settings['description']) ?></textarea>

    <label>Button 1 Text</label>
    <input type="text" name="button1_text" value="<?= old('button1_text', $settings['button1_text']) ?>" required>

    <label>Button 1 Link (relative or absolute)</label>
    <input type="text" name="button1_link" value="<?= old('button1_link', $settings['button1_link']) ?>" required>

    <label>Button 2 Text</label>
    <input type="text" name="button2_text" value="<?= old('button2_text', $settings['button2_text']) ?>" required>

    <label>Button 2 Link (e.g., tel:number)</label>
    <input type="text" name="button2_link" value="<?= old('button2_link', $settings['button2_link']) ?>" required>

    <label>Button 3 Text</label>
    <input type="text" name="button3_text" value="<?= old('button3_text', $settings['button3_text']) ?>" required>

    <label>Button 3 Link (external URL)</label>
    <input type="text" name="button3_link" value="<?= old('button3_link', $settings['button3_link']) ?>" required>

    <button type="submit">Update Section</button>
</form>
<?= $this->endSection() ?>