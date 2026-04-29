<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php
// Ensure $branch is always an array (for edit mode)
$branch = $branch ?? [];
?>
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Branch</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/branches/update/' . $branch['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Branch Name</label>
                <input type="text" name="branch_name" class="form-control" value="<?= esc($branch['branch_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2" required><?= esc($branch['address']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Area</label>
                <input type="text" name="area" class="form-control" value="<?= esc($branch['area']) ?>">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="<?= esc($branch['city']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="<?= esc($branch['pincode']) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">IFSC Code</label>
                    <input type="text" name="ifsc" class="form-control" value="<?= esc($branch['ifsc']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">MICR Code</label>
                    <input type="text" name="micr" class="form-control" value="<?= esc($branch['micr']) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Services (comma separated)</label>
                <textarea name="services" class="form-control" rows="3"><?php
                                                                        $services = json_decode($branch['services'], true);
                                                                        echo esc(is_array($services) ? implode(', ', $services) : '');
                                                                        ?></textarea>
                <small class="text-muted d-block">Example: Deposits, Loans, Lockers, RTGS/NEFT</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= esc($branch['phone']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Timings</label>
                    <input type="text" name="timings" class="form-control" value="<?= esc($branch['timings']) ?>">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="has_atm" value="1" class="form-check-input" id="has_atm" <?= $branch['has_atm'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="has_atm">Has ATM</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= ($branch['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($branch['status'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
                <small class="text-muted d-block">Inactive branches will not appear on the website.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/branches') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>