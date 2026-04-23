<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Digital Section Settings (RTGS / NEFT)</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/digital-settings/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">RTGS Description</label>
                <textarea name="rtgs_description" class="form-control" rows="3" placeholder="e.g., Real Time Gross Settlement for high-value, real-time transfers."><?= esc($settings['rtgs_description'] ?? '') ?></textarea>
                <small class="text-muted d-block">Short description shown on the RTGS/NEFT page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">NEFT Description</label>
                <textarea name="neft_description" class="form-control" rows="3" placeholder="e.g., National Electronic Funds Transfer for batch-processed transfers."><?= esc($settings['neft_description'] ?? '') ?></textarea>
                <small class="text-muted d-block">Short description shown on the RTGS/NEFT page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">RTGS Features (one per line)</label>
                <textarea name="rtgs_features" class="form-control" rows="5" placeholder="Settlement: real-time&#10;Minimum: ₹2,00,000&#10;Availability: 24x7x365"><?= esc($settings['rtgs_features'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">NEFT Features (one per line)</label>
                <textarea name="neft_features" class="form-control" rows="5" placeholder="Settlement: half-hourly batches&#10;Minimum: no minimum&#10;Availability: 24x7x365"><?= esc($settings['neft_features'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Transfer Steps (JSON array)</label>
                <textarea name="rtgs_neft_steps" class="form-control" rows="8" placeholder='[{"step":"1","title":"Collect Details","desc":"Get beneficiary name, account number, IFSC code."},{"step":"2","title":"Visit Branch / Use App","desc":"Use branch-assisted transfer or mobile banking."}]'><?= esc($settings['rtgs_neft_steps'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each step must follow this exact JSON format. The array will be parsed and displayed as step‑by‑step instructions.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/digital-services') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>