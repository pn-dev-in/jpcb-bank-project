<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Loan Interest Scheme</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/loan-interest-schemes/update/' . $item['id']) : base_url('admin/loan-interest-schemes/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Category *</label>
                    <select name="category" class="form-control" required>
                        <option value="retail" <?= (isset($item) && $item['category'] == 'retail') ? 'selected' : '' ?>>Retail</option>
                        <option value="wholesale" <?= (isset($item) && $item['category'] == 'wholesale') ? 'selected' : '' ?>>Wholesale</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Serial No. *</label>
                    <input type="number" name="serial_no" class="form-control" value="<?= old('serial_no', $item['serial_no'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Scheme Name *</label>
                <input type="text" name="scheme_name" class="form-control" value="<?= old('scheme_name', $item['scheme_name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Min ROI (HTML allowed)</label>
                <textarea name="min_roi" class="form-control" rows="4"><?= old('min_roi', $item['min_roi'] ?? '') ?></textarea>
                <small class="text-muted">Use &lt;br/&gt; for line breaks.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Max ROI (HTML allowed)</label>
                <textarea name="max_roi" class="form-control" rows="4"><?= old('max_roi', $item['max_roi'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Women Entrepreneur Benefit</label>
                <input type="text" name="women_benefit" class="form-control" value="<?= old('women_benefit', $item['women_benefit'] ?? '') ?>" maxlength="100">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
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
            <a href="<?= base_url('admin/loan-interest-schemes') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>