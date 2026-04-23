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
                <label class="form-label">Image</label>
                <?php if (isset($item) && $item['image']): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($item['image']) ?>" style="width: 100px; height: 100px; object-fit: cover;">
                        <p class="text-muted small">Current image. Upload new to replace.</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/*" <?= !isset($item) ? 'required' : '' ?>>
                <small class="text-muted d-block">Allowed: JPG, PNG, GIF. Max 5MB.</small>
            </div>
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