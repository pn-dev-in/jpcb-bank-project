<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Service Charge</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/service-charges/update/'.$item['id']) : base_url('admin/service-charges/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Category (e.g., Savings Account)</label>
                <input type="text" name="category" class="form-control" value="<?= old('category', $item['category'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Service Name</label>
                <input type="text" name="service_name" class="form-control" value="<?= old('service_name', $item['service_name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Charge</label>
                <input type="text" name="charge" class="form-control" value="<?= old('charge', $item['charge'] ?? '') ?>" required>
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
            <a href="<?= base_url('admin/service-charges') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>