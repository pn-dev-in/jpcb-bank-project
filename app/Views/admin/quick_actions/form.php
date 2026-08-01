<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($quickAction) ? 'Edit' : 'Add' ?> Quick Action</h3>
    </div>
    <div class="card-body">
        <form method="post"
            action="<?= isset($quickAction) ? site_url('admin/quick-actions/update/' . $quickAction['id']) : site_url('admin/quick-actions/store') ?>"
            enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control"
                    value="<?= old('title', $quickAction['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <input type="text" name="description" class="form-control"
                    value="<?= old('description', $quickAction['description'] ?? '') ?>" maxlength="150">
                <small class="text-muted d-block">Short description shown below title on desktop.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon (Lucide icon name) *</label>
                <input type="text" name="icon" class="form-control"
                    value="<?= old('icon', $quickAction['icon'] ?? '') ?>" required>
                <small class="text-muted d-block">Examples: user-plus, wallet, calculator, percent, smartphone, send,
                    map-pin, credit-card, file-text, receipt, headphones, alert-circle</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Link (URL) *</label>
                <input type="text" name="link" class="form-control"
                    value="<?= old('link', $quickAction['link'] ?? '') ?>" required>
                <small class="text-muted d-block">Relative path or full URL. Example: #open-account or
                    https://example.com</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image (for tab content)</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block">Recommended size: 600x400px. Leave empty to keep existing image.</small>
                
                <?php if (isset($quickAction) && !empty($quickAction['image'])): ?>
                    <div class="mt-2">
                        <img src="<?= base_url($quickAction['image']) ?>" width="100" class="rounded border">
                        <p class="text-muted small mt-1">Current image: <?= basename($quickAction['image']) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Image Path (Alternative - if not uploading)</label>
                <input type="text" name="image" class="form-control" 
                    value="<?= old('image', $quickAction['image'] ?? '') ?>"
                    placeholder="uploads/quick-actions/example.jpg">
                <small class="text-muted d-block">You can enter a path manually instead of uploading a file.</small>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_alert" value="1" class="form-check-input" id="is_alert"
                    <?= (isset($quickAction) && $quickAction['is_alert']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_alert">Mark as Alert (highlight with different color)</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($quickAction) && $quickAction['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($quickAction) && $quickAction['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
                <small class="text-muted d-block">Inactive quick actions will not appear on the homepage.</small>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($quickAction) ? 'Update' : 'Create' ?></button>
            <a href="<?= site_url('admin/quick-actions') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
// Initialize Lucide icons for preview
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<?= $this->endSection() ?>