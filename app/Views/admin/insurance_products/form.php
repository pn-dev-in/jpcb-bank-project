<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Insurance Product</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/insurance-products/update/'.$item['id']) : base_url('admin/insurance-products/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Premium (e.g., ₹20/year)</label>
                <input type="text" name="premium" class="form-control" value="<?= old('premium', $item['premium'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Coverage (e.g., ₹2 lakh accident insurance)</label>
                <input type="text" name="cover" class="form-control" value="<?= old('cover', $item['cover'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Eligibility</label>
                <input type="text" name="eligibility" class="form-control" value="<?= old('eligibility', $item['eligibility'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Features (one per line)</label>
                <textarea name="features" class="form-control" rows="5" required><?= old('features', $featuresText ?? '') ?></textarea>
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
            <a href="<?= base_url('admin/insurance-products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>