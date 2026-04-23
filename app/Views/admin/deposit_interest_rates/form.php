<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Interest Rate</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/deposit-interest-rates/update/'.$item['id']) : base_url('admin/deposit-interest-rates/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Tenure (e.g., 7 days to 14 days)</label>
                <input type="text" name="tenure" class="form-control" value="<?= old('tenure', $item['tenure'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">General Rate (% p.a.)</label>
                <input type="text" name="general_rate" class="form-control" value="<?= old('general_rate', $item['general_rate'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Senior Citizen Rate (% p.a.)</label>
                <input type="text" name="senior_rate" class="form-control" value="<?= old('senior_rate', $item['senior_rate'] ?? '') ?>" required>
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
            <a href="<?= base_url('admin/deposit-interest-rates') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>