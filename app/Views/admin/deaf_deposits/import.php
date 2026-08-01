<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Bulk Import DEAF Deposits</h3>
    </div>
    <div class="card-body">

        <div class="alert alert-info">
            <strong>📋 Instructions:</strong>
            <ul class="mb-0">
                <li>Upload an Excel (.xlsx) or CSV file with the following columns:</li>
                <ul>
                    <li><strong>Sr No</strong> - Serial number (integer)</li>
                    <li><strong>UDRN</strong> - Unique Deposit Reference Number (must be unique)</li>
                    <li><strong>Name</strong> - Depositor's full name</li>
                    <li><strong>Address</strong> - Complete address</li>
                </ul>
                <li>The first row will be treated as header and will be skipped.</li>
                <li>Duplicate UDRN entries will be automatically skipped.</li>
                <li>All imported records will be set to Active status by default.</li>
                <li>Maximum file size: 5MB</li>
            </ul>
        </div>

        <div class="alert alert-warning">
            <strong>⚠️ Note:</strong> Before importing, make sure your Excel/CSV file has the correct format. 
            <a href="<?= base_url('admin/deaf-deposits/sample-excel') ?>" class="alert-link">Download Sample Excel</a> | 
            <a href="<?= base_url('admin/deaf-deposits/sample-csv') ?>" class="alert-link">Download Sample CSV</a>
        </div>

        <form method="post" action="<?= base_url('admin/deaf-deposits/process-import') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Upload File <span class="text-danger">*</span></label>
                <input type="file" name="import_file" class="form-control" accept=".xlsx,.csv" required>
                <small class="text-muted">Allowed file types: .xlsx, .csv | Max size: 5MB</small>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-upload"></i> Upload & Import
            </button>
            <a href="<?= base_url('admin/deaf-deposits') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>