<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2><?= isset($step) ? 'Edit' : 'Add' ?> Grievance Step</h2>
<form method="post" action="<?= isset($step) ? site_url('admin/grievance-steps/update/'.$step['id']) : site_url('admin/grievance-steps/store') ?>">
    <?= csrf_field() ?>
    <label>Step Number</label>
    <input type="number" name="step" value="<?= old('step', $step['step'] ?? '') ?>" required>

    <label>Icon (Lucide name)</label>
    <input type="text" name="icon" value="<?= old('icon', $step['icon'] ?? '') ?>" required>

    <label>Title</label>
    <input type="text" name="title" value="<?= old('title', $step['title'] ?? '') ?>" required>

    <label>Description</label>
    <textarea name="description" rows="3" required><?= old('description', $step['description'] ?? '') ?></textarea>

    <label>Timeline (e.g., Response within 7–15 days)</label>
    <input type="text" name="timeline" value="<?= old('timeline', $step['timeline'] ?? '') ?>" required>

    <label>Action Button Text</label>
    <input type="text" name="action" value="<?= old('action', $step['action'] ?? '') ?>" required>

    <label>Link (URL)</label>
    <input type="text" name="href" value="<?= old('href', $step['href'] ?? '') ?>" required>

    <label>External Link?</label>
    <select name="external">
        <option value="0" <?= (isset($step) && $step['external']==0) ? 'selected' : '' ?>>No (internal)</option>
        <option value="1" <?= (isset($step) && $step['external']==1) ? 'selected' : '' ?>>Yes (opens new tab)</option>
    </select>

    <button type="submit"><?= isset($step) ? 'Update' : 'Create' ?></button>
</form>
<?= $this->endSection() ?>