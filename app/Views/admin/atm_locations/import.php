<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Bulk Import ATM / Branch Data</h3>
    </div>
    <div class="card-body">

        <div class="alert alert-info">
            <strong>Instructions:</strong>
            <ul>
                <li>Upload the Excel file (.xlsx) provided by the bank (contains sheets: "ATM Details", "LAT AND LONGI").</li>
                <li>The system will automatically match and update/insert all ATM locations.</li>
                <li>Required columns in the Excel:
                    <ul>
                        <li><strong>ATM Details sheet:</strong> "Branch Address", "ATM ADDRESSES", "Location"</li>
                        <li><strong>LAT AND LONGI sheet:</strong> "BRANCHNAME", "latitude and longitude", "CITY", "PINCODE"</li>
                    </ul>
                </li>
                <li>Coordinates will be used to show map links on the frontend.</li>
                <li>Existing entries are matched by <code>name + city</code> and updated.</li>
            </ul>
        </div>

        <form method="post" action="<?= base_url('admin/atm-locations/process-import') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Upload Excel File (.xlsx)</label>
                <input type="file" name="import_file" class="form-control" accept=".xlsx" required>
                <small class="text-muted">Max size: 5MB. Only .xlsx files are accepted.</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload & Import</button>
            <a href="<?= base_url('admin/atm-locations') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>