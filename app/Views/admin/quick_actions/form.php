<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($quickAction) ? 'Edit' : 'Add' ?> Quick Action</h2>

<form method="post" action="<?= isset($quickAction) ? site_url('admin/quick-actions/update/'.$quickAction['id']) : site_url('admin/quick-actions/store') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" class="form-control" value="<?= old('title', $quickAction['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Description (optional)</label>
        <input type="text" name="description" class="form-control" value="<?= old('description', $quickAction['description'] ?? '') ?>" maxlength="150">
        <small class="text-muted">Short description shown below title on desktop.</small>
    </div>

    <div class="form-group">
        <label>Icon (Lucide icon name) *</label>
        <input type="text" name="icon" class="form-control" value="<?= old('icon', $quickAction['icon'] ?? '') ?>" required>
        <small class="text-muted">Examples: user-plus, wallet, calculator, percent, smartphone, send, map-pin, credit-card, file-text, receipt, headphones, alert-circle</small>
    </div>

    <div class="form-group">
        <label>Link (URL) *</label>
        <input type="text" name="link" class="form-control" value="<?= old('link', $quickAction['link'] ?? '') ?>" required>
        <small class="text-muted">Relative path or full URL. Example: #open-account or https://example.com</small>
    </div>

    <div class="form-group">
        <label class="checkbox-label">
            <input type="checkbox" name="is_alert" value="1" <?= (isset($quickAction) && $quickAction['is_alert']) ? 'checked' : '' ?>>
            Mark as Alert (highlight with different color)
        </label>
    </div>

    <button type="submit" class="btn btn-primary"><?= isset($quickAction) ? 'Update' : 'Create' ?></button>
    <a href="<?= site_url('admin/quick-actions') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>