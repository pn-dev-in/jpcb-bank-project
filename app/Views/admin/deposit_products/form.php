<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Deposit Product</h3>
    </div>
    <div class="card-body">
        <form method="post"
            action="<?= isset($item) ? base_url('admin/deposit-products/update/' . $item['id']) : base_url('admin/deposit-products/store') ?>"
            enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tenure</label>
                <input type="text" name="tenure" class="form-control"
                    value="<?= old('tenure', $item['tenure'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Minimum Amount</label>
                <input type="text" name="min_amount" class="form-control"
                    value="<?= old('min_amount', $item['min_amount'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Interest Rate</label>
                <input type="text" name="interest_rate" class="form-control"
                    value="<?= old('interest_rate', $item['interest_rate'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Payout</label>
                <input type="text" name="payout" class="form-control"
                    value="<?= old('payout', $item['payout'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Form (PDF)</label>
                <?php if (!empty($item['form_pdf'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($item['form_pdf']) ?>" target="_blank">View current form</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="form_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF form for this deposit product. Leave empty to keep
                    current.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Features (one per line)</label>
                <textarea name="features" class="form-control" rows="5"
                    required><?= old('features', $featuresText ?? '') ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control"
                        value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
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
            <a href="<?= base_url('admin/deposit-products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>