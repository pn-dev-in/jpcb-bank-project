<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($quickAction) ? 'Edit' : 'Add' ?> Quick Action</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($quickAction) ? site_url('admin/quick-actions/update/'.$quickAction['id']) : site_url('admin/quick-actions/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $quickAction['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <input type="text" name="description" class="form-control" value="<?= old('description', $quickAction['description'] ?? '') ?>" maxlength="150">
                <small class="text-muted d-block">Short description shown below title on desktop.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon (Lucide icon name) *</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $quickAction['icon'] ?? '') ?>" required>
                <small class="text-muted d-block">Examples: user-plus, wallet, calculator, percent, smartphone, send, map-pin, credit-card, file-text, receipt, headphones, alert-circle</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Link (URL) *</label>
                <input type="text" name="link" class="form-control" value="<?= old('link', $quickAction['link'] ?? '') ?>" required>
                <small class="text-muted d-block">Relative path or full URL. Example: #open-account or https://example.com</small>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_alert" value="1" class="form-check-input" id="is_alert" <?= (isset($quickAction) && $quickAction['is_alert']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_alert">Mark as Alert (highlight with different color)</label>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($quickAction) ? 'Update' : 'Create' ?></button>
            <a href="<?= site_url('admin/quick-actions') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>