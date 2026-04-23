<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> ATM Location</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/atm-locations/update/'.$item['id']) : base_url('admin/atm-locations/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">ATM Name *</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required placeholder="e.g., Head Office ATM">
                <small class="text-muted d-block">Unique name for the ATM location.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" value="<?= old('city', $item['city'] ?? '') ?>" required placeholder="e.g., Jalgaon">
            </div>

            <div class="mb-3">
                <label class="form-label">Area (optional)</label>
                <input type="text" name="area" class="form-control" value="<?= old('area', $item['area'] ?? '') ?>" placeholder="e.g., Station Road, Market Yard">
                <small class="text-muted d-block">Specific locality or landmark.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">PIN Code</label>
                <input type="text" name="pin" class="form-control" value="<?= old('pin', $item['pin'] ?? '') ?>" placeholder="e.g., 425001">
                <small class="text-muted d-block">Postal code for the location.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Operating Hours</label>
                <input type="text" name="hours" class="form-control" value="<?= old('hours', $item['hours'] ?? '24x7') ?>" placeholder="e.g., 24x7, 9 AM - 9 PM">
                <small class="text-muted d-block">Default is 24x7.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ATM Status</label>
                    <select name="atm_status" class="form-control">
                        <option value="Active" <?= (isset($item) && $item['atm_status']=='Active') ? 'selected' : '' ?>>Active</option>
                        <option value="Maintenance" <?= (isset($item) && $item['atm_status']=='Maintenance') ? 'selected' : '' ?>>Maintenance</option>
                    </select>
                    <small class="text-muted d-block">Shows as "Active" or "Maintenance" on frontend.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>" placeholder="0">
                    <small class="text-muted d-block">Lower numbers appear first.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status (Enabled/Disabled)</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                </select>
                <small class="text-muted d-block">Inactive ATMs will not appear on the website.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/atm-locations') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>