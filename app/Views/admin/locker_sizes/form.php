<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Locker Size</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/locker-sizes/update/'.$item['id']) : base_url('admin/locker-sizes/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Size (e.g., Small)</label>
                <input type="text" name="size" class="form-control" value="<?= old('size', $item['size'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dimensions (e.g., 6" x 12" x 24")</label>
                <input type="text" name="dimensions" class="form-control" value="<?= old('dimensions', $item['dimensions'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Annual Rent</label>
                <input type="text" name="rent" class="form-control" value="<?= old('rent', $item['rent'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Key Deposit</label>
                <input type="text" name="deposit" class="form-control" value="<?= old('deposit', $item['deposit'] ?? '') ?>" required>
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
            <a href="<?= base_url('admin/locker-sizes') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>