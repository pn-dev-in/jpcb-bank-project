<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3><?= isset($category) ? 'Edit Category' : 'Add Category' ?></h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($category) ? base_url('admin/download-categories/update/' . $category['id']) : base_url('admin/download-categories/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $category['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug (URL friendly)</label>
                <input type="text" name="slug" class="form-control" value="<?= old('slug', $category['slug'] ?? '') ?>" required>
                <small class="text-muted">Example: "forms", "policies", "reports"</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $category['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($category) && $category['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($category) && $category['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/download-categories') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>