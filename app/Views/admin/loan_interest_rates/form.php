<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Loan Interest Rate Entry</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/loan-interest-rates/update/'.$item['id']) : base_url('admin/loan-interest-rates/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= old('product_name', $item['product_name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Interest Rate (% p.a.)</label>
                <input type="text" name="rate" class="form-control" value="<?= old('rate', $item['rate'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Processing Fee</label>
                <input type="text" name="processing_fee" class="form-control" value="<?= old('processing_fee', $item['processing_fee'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prepayment Charge</label>
                <input type="text" name="prepayment_charge" class="form-control" value="<?= old('prepayment_charge', $item['prepayment_charge'] ?? '') ?>" required>
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
            <a href="<?= base_url('admin/loan-interest-rates') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>