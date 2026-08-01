<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Deposit Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/deposit-settings/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    DICGC Banner Image
                </label>
                <?php
                $dicgcBanner = $settings['dicgc_banner'] ?? '';
                ?>
                <?php if (!empty($dicgcBanner)): ?>
                    <div class="mb-3">
                        <img src="<?= base_url($dicgcBanner) ?>" alt="DICGC Banner" class="img-fluid border rounded"
                            style="max-width:320px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="dicgc_banner" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">
                    Upload DICGC logo/banner image.
                </small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">
                    DICGC Banner Text
                </label>
                <textarea name="dicgc_banner_text" class="form-control"
                    rows="3"><?= esc($settings['dicgc_banner_text'] ?? '') ?></textarea>
                <small class="text-muted d-block">
                    Example:
                    The Jalgaon Peoples Co-Op. Bank Ltd is registered with DICGC.
                </small>
            </div>
            <div class="mb-3">
                <label class="form-label">DICGC Introduction Text</label>
                <textarea name="dicgc_intro" class="form-control"
                    rows="5"><?= esc($settings['dicgc_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the DICGC page below the "What is DICGC?" heading.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">DEAF Introduction Text</label>
                <textarea name="deaf_intro" class="form-control"
                    rows="5"><?= esc($settings['deaf_intro'] ?? '') ?></textarea>
                <small class="text-muted d-block">Appears on the DEAF page as the introductory paragraph.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">DEAF Claim Form (PDF)</label>
                <?php $currentDeafPdf = $settings['deaf_claim_form_pdf'] ?? ''; ?>
                <?php if (!empty($currentDeafPdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($currentDeafPdf) ?>" target="_blank">View current claim form</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="deaf_claim_form_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload the DEAF claim form PDF.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Interest Rate Notes</label>
                <textarea name="interest_rate_notes" class="form-control"
                    rows="5"><?= esc($settings['interest_rate_notes'] ?? '') ?></textarea>
                <small class="text-muted d-block">Displayed below the interest rate table. Use &lt;br&gt; for line
                    breaks.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Deposit Interest Rate Schedule (PDF)</label>
                <?php $currentPdf = $settings['deposit_rates_pdf'] ?? ''; ?>
                <?php if (!empty($currentPdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($currentPdf) ?>" target="_blank">View current schedule</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="deposit_rates_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF version of the deposit interest rate sheet.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Savings/Current Documents (one per line)</label>
                <textarea name="savings_documents" class="form-control" rows="6"
                    placeholder="PAN Card&#10;Aadhaar Card&#10;Passport-size Photos (2)&#10;Address Proof"><?= esc($settings['savings_documents'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point in the "Documents Required"
                    section.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/deposit-cards') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>