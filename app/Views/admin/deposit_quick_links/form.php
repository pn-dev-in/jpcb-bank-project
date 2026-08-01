<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Quick Link</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/deposit-quick-links/update/'.$item['id']) : base_url('admin/deposit-quick-links/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Icon (Lucide icon name)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $item['icon'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Label</label>
                <input type="text" name="label" class="form-control" value="<?= old('label', $item['label'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Link (relative URL)</label>
                <input type="text" name="href" class="form-control" value="<?= old('href', $item['href'] ?? '') ?>" required>
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
            <a href="<?= base_url('admin/deposit-quick-links') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>