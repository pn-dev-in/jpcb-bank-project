<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Loan Scheme</h3>
    </div>
    <div class="card-body">
        <form method="post"
            action="<?= isset($item) ? base_url('admin/loan-schemes/update/' . $item['id']) : base_url('admin/loan-schemes/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Scheme Name *</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>"
                    required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Max Loan Amount</label>
                    <input type="text" name="max_loan_amount" class="form-control"
                        value="<?= old('max_loan_amount', $item['max_loan_amount'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Max Tenure</label>
                    <input type="text" name="max_tenure" class="form-control"
                        value="<?= old('max_tenure', $item['max_tenure'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Repayment (optional, overrides Max Tenure if filled)</label>
                <input type="text" name="repayment" class="form-control"
                    value="<?= old('repayment', $item['repayment'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Margin</label>
                <input type="text" name="margin" class="form-control"
                    value="<?= old('margin', $item['margin'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Collateral Security</label>
                <textarea name="collateral_security" class="form-control"
                    rows="2"><?= old('collateral_security', $item['collateral_security'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Purpose *</label>
                <textarea name="purpose" class="form-control" rows="3"
                    required><?= old('purpose', $item['purpose'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Eligibility *</label>
                <textarea name="eligibility" class="form-control" rows="3"
                    required><?= old('eligibility', $item['eligibility'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prime Security *</label>
                <textarea name="prime_security" class="form-control" rows="3"
                    required><?= old('prime_security', $item['prime_security'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Form (PDF)</label>
                <?php if (!empty($item['form_pdf'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($item['form_pdf']) ?>" target="_blank">View current form</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="form_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF application form for this loan scheme. Leave empty to keep
                    current.</small>
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
            <a href="<?= base_url('admin/loan-schemes') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>