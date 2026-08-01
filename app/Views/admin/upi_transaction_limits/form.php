<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Transaction Limit</h3>
    </div>
    <div class="card-body">
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= isset($item) ? base_url('admin/upi-transaction-limits/update/'.$item['id']) : base_url('admin/upi-transaction-limits/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Transaction Type</label>
                <select name="transaction_type" class="form-control" required>
                    <option value="Debit" <?= old('transaction_type', $item['transaction_type'] ?? 'Debit') == 'Debit' ? 'selected' : '' ?>>Debit</option>
                    <option value="Credit" <?= old('transaction_type', $item['transaction_type'] ?? '') == 'Credit' ? 'selected' : '' ?>>Credit</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Per Transaction</label>
                    <input type="text" name="per_transaction" class="form-control" value="<?= old('per_transaction', $item['per_transaction'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Per Day Limit</label>
                    <input type="text" name="per_day_limit" class="form-control" value="<?= old('per_day_limit', $item['per_day_limit'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Per Day Count</label>
                    <input type="text" name="per_day_count" class="form-control" value="<?= old('per_day_count', $item['per_day_count'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Per Month Limit</label>
                    <input type="text" name="per_month_limit" class="form-control" value="<?= old('per_month_limit', $item['per_month_limit'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Per Month Count</label>
                    <input type="text" name="per_month_count" class="form-control" value="<?= old('per_month_count', $item['per_month_count'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Per Month UPI Transactions</label>
                    <input type="text" name="per_month_upi" class="form-control" value="<?= old('per_month_upi', $item['per_month_upi'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (old('status', $item['status'] ?? '1') == '1') ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (old('status', $item['status'] ?? '1') == '0') ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/upi-transaction-limits') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>