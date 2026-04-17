<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Branch</h2>

<form method="post" action="<?= base_url('admin/branches/update/'.$branch['id']) ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>Branch Name</label>
        <input type="text" name="branch_name" class="form-control" value="<?= esc($branch['branch_name']) ?>" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea name="address" class="form-control" required><?= esc($branch['address']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Area</label>
        <input type="text" name="area" class="form-control" value="<?= esc($branch['area']) ?>">
    </div>
    <div class="form-group">
        <label>City</label>
        <input type="text" name="city" class="form-control" value="<?= esc($branch['city']) ?>" required>
    </div>
    <div class="form-group">
        <label>Pincode</label>
        <input type="text" name="pincode" class="form-control" value="<?= esc($branch['pincode']) ?>">
    </div>
    <div class="form-group">
        <label>IFSC Code</label>
        <input type="text" name="ifsc" class="form-control" value="<?= esc($branch['ifsc']) ?>">
    </div>
    <div class="form-group">
        <label>MICR Code</label>
        <input type="text" name="micr" class="form-control" value="<?= esc($branch['micr']) ?>">
    </div>
    <div class="form-group">
        <label>Services (comma separated)</label>
        <textarea name="services" class="form-control" rows="3"><?php 
            $services = json_decode($branch['services'], true);
            echo esc(is_array($services) ? implode(', ', $services) : '');
        ?></textarea>
        <small>Example: Deposits, Loans, Lockers, RTGS/NEFT</small>
    </div>
    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= esc($branch['phone']) ?>">
    </div>
    <div class="form-group">
        <label>Timings</label>
        <input type="text" name="timings" class="form-control" value="<?= esc($branch['timings']) ?>">
    </div>
    <div class="form-check">
        <input type="checkbox" name="has_atm" value="1" class="form-check-input" id="has_atm" <?= $branch['has_atm'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="has_atm">Has ATM</label>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/branches') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>