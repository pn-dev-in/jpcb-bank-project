<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Loan Product</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/loan-products/update/'.$item['id']) : base_url('admin/loan-products/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Interest Rate (e.g., 9.50% - 12.00%)</label>
                <input type="text" name="rate" class="form-control" value="<?= old('rate', $item['rate'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Max Tenure (e.g., Up to 7 years)</label>
                <input type="text" name="tenure" class="form-control" value="<?= old('tenure', $item['tenure'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Margin (e.g., 15-25%)</label>
                <input type="text" name="margin" class="form-control" value="<?= old('margin', $item['margin'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Security (e.g., Hypothecation of vehicle)</label>
                <input type="text" name="security" class="form-control" value="<?= old('security', $item['security'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Eligibility</label>
                <textarea name="eligibility" class="form-control" rows="2" required><?= old('eligibility', $item['eligibility'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Features (one per line)</label>
                <textarea name="features" class="form-control" rows="5" required><?= old('features', $featuresText ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Documents Required (one per line)</label>
                <textarea name="documents" class="form-control" rows="5" required><?= old('documents', $docsText ?? '') ?></textarea>
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
            <a href="<?= base_url('admin/loan-products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>