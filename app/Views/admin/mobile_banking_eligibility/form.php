<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Eligibility Rule</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/mobile-banking-eligibility/update/' . $item['id']) : base_url('admin/mobile-banking-eligibility/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Account Type</label>
                <input type="text" name="account_type" class="form-control" value="<?= old('account_type', $item['account_type'] ?? '') ?>" required>
                <small class="text-muted">e.g., Savings Account, Current / Loan Account</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Constitution</label>
                <input type="text" name="constitution" class="form-control" value="<?= old('constitution', $item['constitution'] ?? '') ?>" required>
                <small class="text-muted">e.g., Single, Joint, Individual, Firm</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Mode of Operation</label>
                <input type="text" name="mode_of_operation" class="form-control" value="<?= old('mode_of_operation', $item['mode_of_operation'] ?? '') ?>" required>
                <small class="text-muted">e.g., Single / Either or Survivor, Jointly (all holders must sign)</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Eligible</label>
                <select name="eligible" class="form-control" required>
                    <option value="1" <?= (isset($item) && $item['eligible'] == 1) ? 'selected' : '' ?>>The Account Holder</option>
                    <option value="0" <?= (isset($item) && $item['eligible'] == 0) ? 'selected' : '' ?>>Not Eligible</option>
                </select>
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
            <a href="<?= base_url('admin/mobile-banking-eligibility') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>