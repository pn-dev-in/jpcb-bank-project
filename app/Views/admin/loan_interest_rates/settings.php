<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Loan Interest Rates – Downloadable PDF</h3>
    </div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data"
              action="<?= base_url('admin/loan-interest-rates/update-settings') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Interest Rate Schedule (PDF)</label>
                <?php if (!empty($pdfPath)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($pdfPath) ?>" target="_blank">View current PDF</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="loan_rates_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF version of the loan interest rate sheet.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/loan-interest-rates') ?>" class="btn btn-secondary">Back to Rates</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>