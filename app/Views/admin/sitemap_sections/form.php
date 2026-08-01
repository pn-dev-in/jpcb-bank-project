<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Sitemap Section</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/sitemap-sections/update/'.$item['id']) : base_url('admin/sitemap-sections/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Section Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
                <small class="text-muted d-block">Example: "About", "Deposits", "Support"</small>
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
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/sitemap-sections') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>