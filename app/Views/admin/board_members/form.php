<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Board Member</h3>
    </div>
    <div class="card-body">
        <?php
        $mediaUrl = static function (?string $path): string {
            $path = trim((string) $path);
            if ($path === '') return '';
            return preg_match('~^https?://~i', $path) ? $path : base_url($path);
        };
        ?>
        <form method="post" action="<?= isset($item) ? base_url('admin/board-members/update/' . $item['id']) : base_url('admin/board-members/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role (e.g., Chairman, Director)</label>
                <input type="text" name="role" class="form-control" value="<?= old('role', $item['role'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category (e.g., Office Bearers, Directors)</label>
                <input type="text" name="category" class="form-control" value="<?= old('category', $item['category'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Bio (optional)</label>
                <textarea name="bio" class="form-control" rows="3"><?= old('bio', $item['bio'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <?php if (isset($item) && !empty($item['image'])): ?>
                    <div class="mb-2">
                        <img src="<?= $mediaUrl($item['image']) ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        <p class="text-muted small mt-1">Current image. Upload new to replace.</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif" <?= !isset($item) ? 'required' : '' ?>>
                <small class="text-muted d-block">Allowed: JPG, PNG, GIF. Max 2MB.</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/board-members') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
