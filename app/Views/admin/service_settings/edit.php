<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Service Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/service-settings/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Locker Eligibility List (one per line)</label>
                <textarea name="locker_eligibility_list" class="form-control"
                    rows="8"><?= esc($settings['locker_eligibility_list'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point in the lockers page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Required Fields (one per line)</label>
                <textarea name="positive_pay_fields" class="form-control"
                    rows="8"><?= esc($settings['positive_pay_fields'] ?? '') ?></textarea>
                <small class="text-muted d-block">Fields displayed under "Details Required for Submission".</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Submission Methods (JSON array)</label>
                <textarea name="positive_pay_submission_methods" class="form-control"
                    rows="6"><?= esc($settings['positive_pay_submission_methods'] ?? '') ?></textarea>
                <small class="text-muted d-block">Example: [{"title":"Mobile Banking App","desc":"Go to Services →
                    Positive Pay → Enter cheque details → Submit."}]</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Important Note</label>
                <textarea name="positive_pay_important_note" class="form-control"
                    rows="4"><?= esc($settings['positive_pay_important_note'] ?? '') ?></textarea>
            </div>
            <!-- NEW: Banner HTML -->
            <div class="mb-3">
                <label class="form-label">Positive Pay RBI Banner (HTML supported)</label>
                <textarea name="positive_pay_banner_html" class="form-control"
                    rows="4"><?= esc($settings['positive_pay_banner_html'] ?? '') ?></textarea>
            </div>

            <!-- NEW: How It Works intro -->
            <div class="mb-3">
                <label class="form-label">Positive Pay How It Works</label>
                <textarea name="positive_pay_how_it_works" class="form-control"
                    rows="4"><?= esc($settings['positive_pay_how_it_works'] ?? '') ?></textarea>
            </div>

            <!-- Sample Cheque Image (upload) -->
            <div class="mb-3">
                <label class="form-label">Sample Cheque Image (Positive Pay)</label>
                <?php $sampleImg = $settings['positive_pay_sample_image'] ?? ''; ?>
                <?php if (!empty($sampleImg)): ?>
                    <div class="mb-2"><img src="<?= base_url($sampleImg) ?>" alt="Sample cheque" style="max-height:150px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="positive_pay_sample_image" class="form-control">
                <small class="text-muted">Leave empty to keep current image.</small>
            </div>

            <!-- NEW: Sample image note -->
            <div class="mb-3">
                <label class="form-label">Sample Image Note</label>
                <textarea name="positive_pay_sample_note" class="form-control"
                    rows="2"><?= esc($settings['positive_pay_sample_note'] ?? '') ?></textarea>
            </div>

            <!-- NEW: Footer note -->
            <div class="mb-3">
                <label class="form-label">Positive Pay Footer Note</label>
                <textarea name="positive_pay_footer_note" class="form-control"
                    rows="2"><?= esc($settings['positive_pay_footer_note'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Insurance Section Introduction</label>
                <textarea name="insurance_intro" class="form-control"
                    rows="4"><?= esc($settings['insurance_intro'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">General Insurance Note</label>
                <textarea name="general_insurance_note" class="form-control"
                    rows="4"><?= esc($settings['general_insurance_note'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Health Insurance Introduction</label>
                <textarea name="health_insurance_intro" class="form-control"
                    rows="4"><?= esc($settings['health_insurance_intro'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">PMJJBY Note</label>
                <textarea name="pmjjby_note" class="form-control"
                    rows="4"><?= esc($settings['pmjjby_note'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">PMSBY Note</label>
                <textarea name="pmsby_note" class="form-control"
                    rows="4"><?= esc($settings['pmsby_note'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tie-Up Partners Note</label>
                <textarea name="tieup_partners_note" class="form-control"
                    rows="4"><?= esc($settings['tieup_partners_note'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Service Charges Schedule (PDF)</label>
                <?php $chargesPdf = $settings['service_charges_pdf'] ?? ''; ?>
                <?php if (!empty($chargesPdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($chargesPdf) ?>" target="_blank">View current schedule</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="service_charges_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF version of the service charges schedule.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Charges Effective Date</label>
                <input type="text" name="charges_effective_date" class="form-control"
                    value="<?= esc($settings['charges_effective_date'] ?? '') ?>">
                <small class="text-muted d-block">
                    Example: 01 October 2025
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Advances Penal Charges Note</label>
                <textarea name="charges_advances_penal_note" class="form-control"
                    rows="8"><?= esc($settings['charges_advances_penal_note'] ?? '') ?></textarea>
                <small class="text-muted d-block">
                    HTML formatting like &lt;strong&gt; and &lt;em&gt; is supported.
                </small>
            </div>
            <div class="mb-3">
                <label class="form-label">Cash Charges Note</label>
                <textarea name="charges_cash_note" class="form-control"
                    rows="8"><?= esc($settings['charges_cash_note'] ?? '') ?></textarea>
                <small class="text-muted d-block">
                    HTML formatting like &lt;strong&gt; and &lt;em&gt; is supported.
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/service-cards') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>