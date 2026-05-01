<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Gallery Item</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/gallery-items/update/'.$item['id']) : base_url('admin/gallery-items/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($item) && $item['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
    <label class="form-label">Event Date (optional)</label>
    <input type="date" name="event_date" class="form-control" value="<?= old('event_date', $item['event_date'] ?? '') ?>">
</div>
            <div class="mb-3">
    <label class="form-label">Main Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    <?php if (!empty($item['image'])): ?>
        <img src="<?= base_url($item['image']) ?>" style="max-width: 200px;" class="mt-2">
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Additional Images (sub‑photos)</label>
    <input type="file" name="sub_images[]" class="form-control" accept="image/*" multiple>
    <small class="text-muted">You can select multiple images. Existing ones are listed below.</small>
</div>

<?php if (!empty($subImages)): ?>
    <div class="mb-3">
        <label class="form-label">Current Sub‑Photos (uncheck to delete)</label>
        <div class="row">
            <?php foreach ($subImages as $sub): ?>
                <div class="col-md-3 text-center mb-2">
                    <img src="<?= base_url($sub['image_path']) ?>" style="max-width: 100px;" class="img-thumbnail">
                    <div class="form-check">
                        <input type="checkbox" name="keep_sub_image_ids[]" value="<?= $sub['id'] ?>" checked> Keep
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($item) ? 'Update' : 'Upload' ?></button>
            <a href="<?= base_url('admin/gallery-items') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>