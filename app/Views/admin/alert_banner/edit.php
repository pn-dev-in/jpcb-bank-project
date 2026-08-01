<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php
$banner = $banner ??[];
?>
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Alert Banner</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/alert-banner/update/' . ($banner['id'] ?? 0)) ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <?php if (!empty($banner['image'])): ?>
                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <img src="<?= base_url($banner['image']) ?>" style="max-width: 300px; border: 1px solid #ddd; padding: 5px;">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Title (optional)</label>
                <input type="text" name="title" class="form-control" value="<?= esc($banner['title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="2"><?= esc($banner['description'] ?? '') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (($banner['status'] ?? 1) == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (($banner['status'] ?? 1) == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Display as Popup?</label>
                    <select name="is_popup" class="form-control">
                        <option value="0" <?= (($banner['is_popup'] ?? 0) == 0) ? 'selected' : '' ?>>No (inline)</option>
                        <option value="1" <?= (($banner['is_popup'] ?? 0) == 1) ? 'selected' : '' ?>>Yes (popup)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Banner</button>
            <a href="<?= base_url('admin/alert-banner') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>