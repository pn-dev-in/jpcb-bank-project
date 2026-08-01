<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> What's New Item</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/whats-new/update/' . $item['id']) : base_url('admin/whats-new/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content *</label>
                <textarea name="content" rows="5" class="form-control" required><?= old('content', $item['content'] ?? '') ?></textarea>
                <small class="text-muted">HTML tags allowed for better formatting.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Image (Optional)</label>
                <?php if (isset($item) && !empty($item['image'])): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($item['image']) ?>" style="max-width: 150px; max-height: 100px; border-radius: 8px; border: 1px solid #ddd;" alt="Current image">
                        <p class="text-muted small mt-1">Current image</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="text-muted">Allowed: JPG, PNG, WEBP. Max size: 2MB. Recommended size: 600 x 400px</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="announcement" <?= (isset($item) && $item['type'] == 'announcement') ? 'selected' : '' ?>>📢 Announcement</option>
                        <option value="update" <?= (isset($item) && $item['type'] == 'update') ? 'selected' : '' ?>🔄 Update</option>
                        <option value="offer" <?= (isset($item) && $item['type'] == 'offer') ? 'selected' : '' ?>🎉 Offer</option>
                        <option value="news" <?= (isset($item) && $item['type'] == 'news') ? 'selected' : '' ?>📰 News</option>
                        <option value="alert" <?= (isset($item) && $item['type'] == 'alert') ? 'selected' : '' ?>⚠️ Alert</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Button Text (Optional)</label>
                    <input type="text" name="link_text" class="form-control" value="<?= old('link_text', $item['link_text'] ?? '') ?>" placeholder="e.g., Learn More, Apply Now">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Link (Optional)</label>
                    <input type="text" name="link_url" class="form-control" value="<?= old('link_url', $item['link_url'] ?? '') ?>" placeholder="e.g., /deposits/interest-rates">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" name="is_sticky" class="form-check-input" id="isSticky" value="1" <?= (isset($item) && $item['is_sticky']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="isSticky">Show in Sticky Notification Bar</label>
        </div>
        <small class="text-muted">This will appear in the persistent marquee bar at top/bottom of page</small>
    </div>
    <div class="col-md-6" id="stickySettings" style="<?= (!isset($item) || !$item['is_sticky']) ? 'display:none' : '' ?>">
        <label class="form-label">Sticky Position</label>
        <select name="sticky_position" class="form-control">
            <option value="top" <?= (isset($item) && $item['sticky_position'] == 'top') ? 'selected' : '' ?>>Top of Page</option>
            <option value="bottom" <?= (isset($item) && $item['sticky_position'] == 'bottom') ? 'selected' : '' ?>>Bottom of Page</option>
        </select>
    </div>
</div>

<div class="row mb-3" id="stickyColors" style="<?= (!isset($item) || !$item['is_sticky']) ? 'display:none' : '' ?>">
    <div class="col-md-6">
        <label class="form-label">Background Color</label>
        <div class="d-flex gap-2">
            <input type="color" name="bg_color" class="form-control form-control-color w-25" value="<?= old('bg_color', $item['bg_color'] ?? '#15803d') ?>">
            <input type="text" name="bg_color_text" class="form-control" placeholder="#15803d" value="<?= old('bg_color', $item['bg_color'] ?? '#15803d') ?>">
        </div>
        <small>Choose from preset: <span class="btn-sm" style="background:#166534; color:white" onclick="setColor('#166534')">Green</span> <span class="btn-sm" style="background:#1e40af; color:white" onclick="setColor('#1e40af')">Blue</span> <span class="btn-sm" style="background:#b91c1c; color:white" onclick="setColor('#b91c1c')">Red</span> <span class="btn-sm" style="background:#d97706; color:white" onclick="setColor('#d97706')">Orange</span></small>
    </div>
    <div class="col-md-6">
        <label class="form-label">Text Color</label>
        <div class="d-flex gap-2">
            <input type="color" name="text_color" class="form-control form-control-color w-25" value="<?= old('text_color', $item['text_color'] ?? '#ffffff') ?>">
            <input type="text" name="text_color_text" class="form-control" placeholder="#ffffff" value="<?= old('text_color', $item['text_color'] ?? '#ffffff') ?>">
        </div>
    </div>
</div>

<script>
document.getElementById('isSticky')?.addEventListener('change', function() {
    const stickySettings = document.getElementById('stickySettings');
    const stickyColors = document.getElementById('stickyColors');
    if (this.checked) {
        stickySettings.style.display = '';
        stickyColors.style.display = '';
    } else {
        stickySettings.style.display = 'none';
        stickyColors.style.display = 'none';
    }
});

function setColor(color) {
    document.querySelector('[name="bg_color"]').value = color;
    document.querySelector('[name="bg_color_text"]').value = color;
}
</script>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/whats-new') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>