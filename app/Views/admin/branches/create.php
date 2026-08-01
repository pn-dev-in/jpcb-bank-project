<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Add Branch</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/branches/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Branch Name</label>
                <input type="text" name="branch_name" class="form-control" placeholder="Branch Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Address" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Area (e.g., Station Road)</label>
                <input type="text" name="area" class="form-control" placeholder="Area">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pincode</label>
                    <input type="text" name="pincode" class="form-control" placeholder="Pincode">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">IFSC Code</label>
                    <input type="text" name="ifsc" class="form-control" placeholder="IFSC Code">
                </div>
                <div class="col-md-6">
                    <label class="form-label">MICR Code</label>
                    <input type="text" name="micr" class="form-control" placeholder="MICR Code">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Services (comma separated, e.g. Deposits, Loans, Lockers)</label>
                <textarea name="services" class="form-control" rows="3" placeholder="Deposits, Loans, Lockers"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Timings</label>
                    <input type="text" name="timings" class="form-control" placeholder="Timings">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="has_atm" value="1" class="form-check-input" id="has_atm">
                <label class="form-check-label" for="has_atm">Has ATM</label>

            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
                <small class="text-muted d-block">Inactive branches will not appear on the website.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/branches') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>