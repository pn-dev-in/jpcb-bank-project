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

        <form method="post" action="<?= isset($item) ? base_url('admin/digital-transaction-limits/update/'.$item['id']) : base_url('admin/digital-transaction-limits/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Channel *</label>
                    <select name="channel" class="form-control" required>
                        <option value="UPI" <?= old('channel', $item['channel'] ?? '') == 'UPI' ? 'selected' : '' ?>>UPI</option>
                        <option value="IMPS" <?= old('channel', $item['channel'] ?? '') == 'IMPS' ? 'selected' : '' ?>>IMPS</option>
                        <option value="NEFT" <?= old('channel', $item['channel'] ?? '') == 'NEFT' ? 'selected' : '' ?>>NEFT</option>
                        <option value="RTGS" <?= old('channel', $item['channel'] ?? '') == 'RTGS' ? 'selected' : '' ?>>RTGS</option>
                        <option value="ATM" <?= old('channel', $item['channel'] ?? '') == 'ATM' ? 'selected' : '' ?>>ATM</option>
                        <option value="ECOM/POS" <?= old('channel', $item['channel'] ?? '') == 'ECOM/POS' ? 'selected' : '' ?>>ECOM / POS</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" value="<?= old('description', $item['description'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Min Per Txn</label>
                    <input type="text" name="min_per_txn" class="form-control" value="<?= old('min_per_txn', $item['min_per_txn'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Max Per Txn</label>
                    <input type="text" name="max_per_txn" class="form-control" value="<?= old('max_per_txn', $item['max_per_txn'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Max Per Day</label>
                    <input type="text" name="max_per_day" class="form-control" value="<?= old('max_per_day', $item['max_per_day'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Max Per Month</label>
                    <input type="text" name="max_per_month" class="form-control" value="<?= old('max_per_month', $item['max_per_month'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Per Day Count</label>
                    <input type="text" name="per_day_count" class="form-control" value="<?= old('per_day_count', $item['per_day_count'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Per Month Count</label>
                    <input type="text" name="per_month_count" class="form-control" value="<?= old('per_month_count', $item['per_month_count'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Availability</label>
                    <input type="text" name="availability" class="form-control" value="<?= old('availability', $item['availability'] ?? '00:00 to 24.00 24X7') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (old('status', $item['status'] ?? '1') == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (old('status', $item['status'] ?? '1') == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/digital-transaction-limits') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>