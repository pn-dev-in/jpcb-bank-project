<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Digital Banking – Page Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/digital-settings/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- ================= General Digital / Mobile Banking ================= -->
            <h5 class="border-bottom pb-2 mb-3">General Digital / Mobile Banking</h5>

            <div class="mb-3">
                <label class="form-label">Digital Overview Intro (shown on /digital/overview)</label>
                <textarea name="digital_overview_intro" class="form-control"
                    rows="3"><?= esc($settings['digital_overview_intro'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Banking Intro (shown under Features tab)</label>
                <textarea name="mobile_banking_intro" class="form-control"
                    rows="3"><?= esc($settings['mobile_banking_intro'] ?? '') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Google Play App URL</label>
                    <input type="url" name="google_play_url" class="form-control"
                        value="<?= esc($settings['google_play_url'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">App Store URL</label>
                    <input type="url" name="app_store_url" class="form-control"
                        value="<?= esc($settings['app_store_url'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Facility Text (shown on “Facility” tab)</label>
                <textarea name="mobile_facility_text" class="form-control"
                    rows="2"><?= esc($settings['mobile_facility_text'] ?? '') ?></textarea>
            </div>

            <!-- ================= RTGS / NEFT Settings ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">RTGS / NEFT Settings</h5>

            <div class="mb-3">
                <label class="form-label">RTGS Description</label>
                <textarea name="rtgs_description" class="form-control"
                    rows="3"><?= esc($settings['rtgs_description'] ?? '') ?></textarea>
                <small class="text-muted">Short description shown on the RTGS/NEFT page.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">NEFT Description</label>
                <textarea name="neft_description" class="form-control"
                    rows="3"><?= esc($settings['neft_description'] ?? '') ?></textarea>
                <small class="text-muted">Short description shown on the RTGS/NEFT page.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">RTGS Features (one per line)</label>
                <textarea name="rtgs_features" class="form-control"
                    rows="5"><?= esc($settings['rtgs_features'] ?? '') ?></textarea>
                <small class="text-muted">Each line becomes a bullet point.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">NEFT Features (one per line)</label>
                <textarea name="neft_features" class="form-control"
                    rows="5"><?= esc($settings['neft_features'] ?? '') ?></textarea>
                <small class="text-muted">Each line becomes a bullet point.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">RTGS/NEFT Form (PDF)</label>
                <?php $rtgsPdf = $settings['rtgs_neft_form_pdf'] ?? ''; ?>
                <?php if (!empty($rtgsPdf)): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($rtgsPdf) ?>" target="_blank">View current form</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="rtgs_neft_form_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload the RTGS/NEFT application form PDF.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Transfer Steps (JSON array)</label>
                <textarea name="rtgs_neft_steps" class="form-control"
                    rows="8"><?= esc($settings['rtgs_neft_steps'] ?? '') ?></textarea>
                <small class="text-muted">Format:
                    <code>[{"step":"1","title":"Collect Details","desc":"Get beneficiary details"},...]</code></small>
            </div>

            <!-- ================= ATM Overview Settings ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">ATM Overview Settings</h5>
            <div class="mb-3">
                <label class="form-label">ATM Overview Intro Text</label>
                <textarea name="atm_overview_intro" class="form-control"
                    rows="5"><?= esc($settings['atm_overview_intro'] ?? '') ?></textarea>
                <small class="text-muted">Use <code>COUNT_PLACEHOLDER</code> – will be replaced with the actual number
                    of ATMs automatically.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">ATM Quick Block Text</label>
                <textarea name="atm_quick_block_text" class="form-control"
                    rows="2"><?= esc($settings['atm_quick_block_text'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">ATM Quick Block SMS Instruction</label>
                <input type="text" name="atm_quick_block_sms" class="form-control"
                    value="<?= esc($settings['atm_quick_block_sms'] ?? '') ?>">
                <small class="text-muted">Example: <code>BLOCK → Send to 8750587505</code></small>
            </div>
            <div class="mb-3">
                <label class="form-label">ATM Quick Block Note</label>
                <input type="text" name="atm_quick_block_note" class="form-control"
                    value="<?= esc($settings['atm_quick_block_note'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">ATM Important Guidelines Heading</label>
                <input type="text" name="atm_overview_guidelines_heading" class="form-control"
                    value="<?= esc($settings['atm_overview_guidelines_heading'] ?? '') ?>">
            </div>

            <!-- ================= Debit Card Section ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">Debit Card Section</h5>
            <div class="mb-3">
                <label class="form-label">Debit Card Heading</label>
                <input type="text" name="debit_card_heading" class="form-control"
                    value="<?= esc($settings['debit_card_heading'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Debit Card Description</label>
                <textarea name="debit_card_description" class="form-control"
                    rows="3"><?= esc($settings['debit_card_description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Debit Card Bullets (pipe‑separated)</label>
                <textarea name="debit_card_bullets" class="form-control"
                    rows="3"><?= esc($settings['debit_card_bullets'] ?? '') ?></textarea>
                <small class="text-muted">Separate each bullet with a pipe | . Example: "Item 1|Item 2|Item 3"</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Debit Card Usage (pipe‑separated)</label>
                <textarea name="debit_card_usage" class="form-control"
                    rows="3"><?= esc($settings['debit_card_usage'] ?? '') ?></textarea>
                <small class="text-muted">Each item will be displayed in a list with an icon.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Debit Card Benefits (pipe‑separated)</label>
                <textarea name="debit_card_benefits" class="form-control"
                    rows="2"><?= esc($settings['debit_card_benefits'] ?? '') ?></textarea>
                <small class="text-muted">Each benefit will be displayed in a two‑column grid.</small>
            </div>

            <!-- ================= ATM Green PIN Note ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">ATM Content</h5>
            <div class="mb-3">
                <label class="form-label">ATM Green PIN Note</label>
                <textarea name="atm_green_pin_note" class="form-control"
                    rows="2"><?= esc($settings['atm_green_pin_note'] ?? '') ?></textarea>
                <small class="text-muted">Shown in the "Avail Services" tab.</small>
            </div>

            <!-- ================= Mobile Banking – Additional ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">Mobile Banking – Additional</h5>
            <div class="mb-3">
                <label class="form-label">JPCB Website URL</label>
                <input type="url" name="jpcb_website_url" class="form-control"
                    value="<?= esc($settings['jpcb_website_url'] ?? '') ?>">
                <small class="text-muted">Used in the “How to Avail” tab for the app download link.</small>
            </div>

            <!-- ================= Transfer Limits ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">Transfer Limits (IMPS / NEFT)</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">IMPS – Per Transaction Limit (₹)</label>
                    <input type="text" name="imps_limit_per_txn" class="form-control"
                        value="<?= esc($settings['imps_limit_per_txn'] ?? '') ?>" placeholder="5,00,000">
                </div>
                <div class="col-md-6">
                    <label class="form-label">IMPS – Per Day Limit (₹)</label>
                    <input type="text" name="imps_limit_per_day" class="form-control"
                        value="<?= esc($settings['imps_limit_per_day'] ?? '') ?>" placeholder="10,00,000">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">NEFT – Per Transaction Limit (₹)</label>
                    <input type="text" name="neft_limit_per_txn" class="form-control"
                        value="<?= esc($settings['neft_limit_per_txn'] ?? '') ?>" placeholder="2,00,000">
                </div>
                <div class="col-md-6">
                    <label class="form-label">NEFT – Per Day Limit (₹)</label>
                    <input type="text" name="neft_limit_per_day" class="form-control"
                        value="<?= esc($settings['neft_limit_per_day'] ?? '') ?>" placeholder="30,00,000">
                </div>
            </div>


            <h5 class="border-bottom pb-2 mb-3 mt-4">Mobile Banking – Facility Tab (Receive Money via IMPS)</h5>

            <div class="mb-3">
                <label class="form-label">Facility Heading</label>
                <input type="text" name="mobile_facility_heading" class="form-control"
                    value="<?= esc($settings['mobile_facility_heading'] ?? '') ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Option 1 Title</label>
                    <input type="text" name="mobile_facility_option1_title" class="form-control"
                        value="<?= esc($settings['mobile_facility_option1_title'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Option 1 Icon (Lucide name)</label>
                    <input type="text" name="mobile_facility_option1_icon" class="form-control"
                        value="<?= esc($settings['mobile_facility_option1_icon'] ?? '') ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Option 1 Text (HTML allowed)</label>
                <textarea name="mobile_facility_option1_text" class="form-control"
                    rows="2"><?= esc($settings['mobile_facility_option1_text'] ?? '') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Option 2 Title</label>
                    <input type="text" name="mobile_facility_option2_title" class="form-control"
                        value="<?= esc($settings['mobile_facility_option2_title'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Option 2 Icon (Lucide name)</label>
                    <input type="text" name="mobile_facility_option2_icon" class="form-control"
                        value="<?= esc($settings['mobile_facility_option2_icon'] ?? '') ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Option 2 Text (HTML allowed)</label>
                <textarea name="mobile_facility_option2_text" class="form-control"
                    rows="2"><?= esc($settings['mobile_facility_option2_text'] ?? '') ?></textarea>
            </div>

            <!-- ================= UPI Section Settings (NEW) ================= -->
            <h5 class="border-bottom pb-2 mb-3 mt-4">UPI Section Settings</h5>

            <div class="mb-3">
                <label class="form-label">UPI Header Eyebrow</label>
                <input type="text" name="upi_header_eyebrow" class="form-control"
                    value="<?= esc($settings['upi_header_eyebrow'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Header Title</label>
                <input type="text" name="upi_header_title" class="form-control"
                    value="<?= esc($settings['upi_header_title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Header Description</label>
                <textarea name="upi_header_description" class="form-control"
                    rows="3"><?= esc($settings['upi_header_description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Features Title</label>
                <input type="text" name="upi_features_title" class="form-control"
                    value="<?= esc($settings['upi_features_title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Features Subtitle</label>
                <input type="text" name="upi_features_subtitle" class="form-control"
                    value="<?= esc($settings['upi_features_subtitle'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Features Overview Title</label>
                <input type="text" name="upi_features_overview_title" class="form-control"
                    value="<?= esc($settings['upi_features_overview_title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Eligibility Title</label>
                <input type="text" name="upi_eligibility_title" class="form-control"
                    value="<?= esc($settings['upi_eligibility_title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Eligibility Subtitle</label>
                <input type="text" name="upi_eligibility_subtitle" class="form-control"
                    value="<?= esc($settings['upi_eligibility_subtitle'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Transactions Title</label>
                <input type="text" name="upi_transactions_title" class="form-control"
                    value="<?= esc($settings['upi_transactions_title'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">UPI Transactions Subtitle</label>
                <input type="text" name="upi_transactions_subtitle" class="form-control"
                    value="<?= esc($settings['upi_transactions_subtitle'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/digital-services') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>