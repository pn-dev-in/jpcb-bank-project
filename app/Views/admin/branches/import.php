<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Bulk Import Branches (Excel)</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="alert alert-info">
            <strong>Instructions:</strong>
            <ul>
                <li>Upload the bank’s Excel file (.xlsx) containing the <strong>"FINAL SHEET MVM"</strong> sheet.</li>
                <li>The first row must contain column headers exactly as in the bank’s file.</li>
                <li>The system will match existing branches by <code>IFSC Code</code> (or fallback to <code>Branch Name + City</code>).</li>
                <li>All fields (address, IFSC, MICR, coordinates, phone, email, timings) will be updated.</li>
            </ul>
        </div>

        <form method="post" action="<?= base_url('admin/branches/process-import') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Upload Excel File (.xlsx)</label>
                <input type="file" name="import_file" class="form-control" accept=".xlsx" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload & Import</button>
            <a href="<?= base_url('admin/branches') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>