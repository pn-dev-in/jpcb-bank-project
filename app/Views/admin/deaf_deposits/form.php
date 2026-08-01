<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> DEAF Deposit</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/deaf-deposits/update/' . $item['id']) : base_url('admin/deaf-deposits/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sr. No. *</label>
                    <input type="number" name="sr_no" class="form-control" value="<?= old('sr_no', $item['sr_no'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">UDRN *</label>
                    <input type="text" name="udrn" class="form-control" value="<?= old('udrn', $item['udrn'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address *</label>
                <textarea name="address" rows="2" class="form-control" required><?= old('address', $item['address'] ?? '') ?></textarea>
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
            <a href="<?= base_url('admin/deaf-deposits') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>