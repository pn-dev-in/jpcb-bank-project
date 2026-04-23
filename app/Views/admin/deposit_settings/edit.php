<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Deposit Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/deposit-settings/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">DICGC Introduction Text</label>
                <textarea name="dicgc_intro" class="form-control" rows="5"><?= esc($settings['dicgc_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the DICGC page below the "What is DICGC?" heading.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">DEAF Introduction Text</label>
                <textarea name="deaf_intro" class="form-control" rows="5"><?= esc($settings['deaf_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the DEAF page as the introductory paragraph.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Interest Rate Notes</label>
                <textarea name="interest_rate_notes" class="form-control" rows="5"><?= esc($settings['interest_rate_notes'] ?? '') ?></textarea>
                <small class="text-muted d-block">Displayed below the interest rate table. Use &lt;br&gt; for line breaks.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Savings/Current Documents (one per line)</label>
                <textarea name="savings_documents" class="form-control" rows="6" placeholder="PAN Card&#10;Aadhaar Card&#10;Passport-size Photos (2)&#10;Address Proof"><?= esc($settings['savings_documents'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point in the "Documents Required" section.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/deposit-cards') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>