<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Homepage Slider</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/home-sliders/update/' . $item['id']) : base_url('admin/home-sliders/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title (Optional)</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>">
                <small class="text-muted">Main heading displayed on the slider image</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Subtitle (Optional)</label>
                <textarea name="subtitle" rows="2" class="form-control"><?= old('subtitle', $item['subtitle'] ?? '') ?></textarea>
                <small class="text-muted">Supporting text below the title</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Slider Image *</label>
                <?php if (isset($item) && !empty($item['image'])): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($item['image']) ?>" style="max-width: 300px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;" alt="Current image">
                        <p class="text-muted small mt-1">Current image</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp,image/jpg" <?= isset($item) ? '' : 'required' ?>>
                <small class="text-muted">Allowed formats: JPG, PNG, WEBP. Max size: 5MB. Recommended size: 1200 x 400 pixels</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Button Text (Optional)</label>
                <input type="text" name="button_text" class="form-control" value="<?= old('button_text', $item['button_text'] ?? '') ?>" placeholder="e.g., Learn More, Apply Now">
                <small class="text-muted">Text displayed on the button</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Button Link (Optional)</label>
                <input type="text" name="button_link" class="form-control" value="<?= old('button_link', $item['button_link'] ?? '') ?>" placeholder="e.g., /deposits/interest-rates">
                <small class="text-muted">Internal page URL (e.g., /deposits/interest-rates) or external link (e.g., https://example.com)</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> <strong>Tip for best results:</strong>
                <ul class="mb-0 mt-1">
                    <li>Use high-quality images with minimum width 1200px</li>
                    <li>Keep important text/logo in the center or left side (dark overlay will be added for text readability)</li>
                    <li>Optimize image size for faster loading (compress before uploading)</li>
                </ul>
            </div>

            <button type="submit" class="btn btn-primary">Save Slider</button>
            <a href="<?= base_url('admin/home-sliders') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>