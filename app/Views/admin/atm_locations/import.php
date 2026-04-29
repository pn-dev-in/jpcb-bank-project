<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Bulk Import ATM Locations</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="alert alert-info">
            <strong>CSV Format Requirements:</strong>
            <ul class="mb-0">
                <li>First row must be headers: <code>name,unique_id, city, area, pin, hours, atm_status, sort_order, status</code></li>
                <li><code>name</code> and <code>city</code> are required.</li>
                <li><code>atm_status</code> values: <code>Active</code> or <code>Maintenance</code> (default Active)</li>
                <li><code>status</code> values: <code>Active</code> / <code>1</code> or <code>Inactive</code> / <code>0</code></li>
                <li>If a record with the same name and city already exists, it will be updated.</li>
            </ul>
        </div>

        <form method="post" action="<?= base_url('admin/atm-locations/process-import') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">CSV File</label>
                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                <small class="text-muted">Maximum size: 2MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload & Import</button>
            <a href="<?= base_url('admin/atm-locations') ?>" class="btn btn-secondary">Cancel</a>
        </form>

        <hr>
        <h5>Sample CSV Template</h5>
        <pre style="background: #f5f5f5; padding: 10px;">name,unique_id,city,area,pin,hours,atm_status,sort_order,status
Head Office ATM,JPCB-ATM-001,Jalgaon,Station Road,425001,24x7,Active,1,Active
Market Yard ATM,JPCB-ATM-002,Jalgaon,Market Yard,425001,24x7,Active,2,Active
Bhusawal ATM,JPCB-ATM-003,Bhusawal,Station Road,425201,24x7,Active,3,Active</pre>
        <a href="<?= base_url('admin/atm-locations/sample-csv') ?>" class="btn btn-sm btn-outline-primary">Download Sample CSV</a>
    </div>
</div>

<?= $this->endSection() ?>