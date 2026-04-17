<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Add Branch</h2>

<form method="post" action="<?= base_url('admin/branches/store') ?>">
    <?= csrf_field() ?>

    <input type="text" name="branch_name" placeholder="Branch Name"><br>
    <textarea name="address" placeholder="Address"></textarea><br>
    <input type="text" name="area" placeholder="Area (e.g., Station Road)"><br>
    <input type="text" name="city" placeholder="City"><br>
    <input type="text" name="pincode" placeholder="Pincode"><br>
    <input type="text" name="ifsc" placeholder="IFSC Code"><br>
    <input type="text" name="micr" placeholder="MICR Code"><br>
    <textarea name="services" placeholder="Services (comma separated, e.g. Deposits, Loans, Lockers)"></textarea><br>
    <input type="text" name="phone" placeholder="Phone"><br>
    <input type="text" name="timings" placeholder="Timings"><br>

    <label>
        <input type="checkbox" name="has_atm" value="1"> Has ATM
    </label><br>

    <button type="submit">Save</button>
</form>

<?= $this->endSection() ?>