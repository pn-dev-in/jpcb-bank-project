<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">General Settings & Header/Footer Configuration</h3>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p class="mb-0"><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/settings/update') ?>">
            <?= csrf_field() ?>

            <h6 class="border-bottom pb-2 mb-3">General Information</h6>
            <div class="mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control"
                    value="<?= old('site_name', $settings['site_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number (display format)</label>
                <input type="text" name="phone" class="form-control" value="<?= old('phone', $settings['phone']) ?>"
                    required>
                <small class="text-muted d-block">Example: 0257-2220055</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= old('email', $settings['email']) ?>"
                    required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone (Alternate)</label>
                    <input type="text" name="phone_alternate" class="form-control"
                        value="<?= old('phone_alternate', $settings['phone_alternate'] ?? '') ?>">
                    <small class="text-muted">e.g., 0257-2272813</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Toll Free Number</label>
                    <input type="text" name="toll_free" class="form-control"
                        value="<?= old('toll_free', $settings['toll_free'] ?? '') ?>">
                    <small class="text-muted">e.g., 1800 233 1385</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Helpline Number (1600 series)</label>
                    <input type="text" name="helpline" class="form-control"
                        value="<?= old('helpline', $settings['helpline'] ?? '') ?>">
                    <small class="text-muted">e.g., 1600 11 21 51</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email (24x7 Support)</label>
                    <input type="email" name="email_support" class="form-control"
                        value="<?= old('email_support', $settings['email_support'] ?? '') ?>">
                    <small class="text-muted">e.g., customercare@jpc.bank.in</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Business Hours</label>
                <input type="text" name="business_hours" class="form-control"
                    value="<?= old('business_hours', $settings['business_hours']) ?>" required>
                <small class="text-muted d-block">Example: Mon-Sat: 10:00 AM - 4:00 PM</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Address (footer fallback)</label>
                <textarea name="address" class="form-control"
                    rows="2"><?= old('address', $settings['address']) ?></textarea>
            </div>

            <h6 class="border-bottom pb-2 mb-3 mt-4">Header Links Configuration</h6>
            <div class="mb-3">
                <label class="form-label">Digital Banking Button Text</label>
                <input type="text" name="digital_banking_button_text" class="form-control"
                    value="<?= old('digital_banking_button_text', $settings['digital_banking_button_text']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Digital Banking Link</label>
                <input type="text" name="digital_banking_link" class="form-control"
                    value="<?= old('digital_banking_link', $settings['digital_banking_link']) ?>" required>
                <small class="text-muted d-block">Relative URL: digital/mobile-banking</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Locate Branch Link</label>
                <input type="text" name="locate_branch_link" class="form-control"
                    value="<?= old('locate_branch_link', $settings['locate_branch_link']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Block ATM Card Link</label>
                <input type="text" name="block_card_link" class="form-control"
                    value="<?= old('block_card_link', $settings['block_card_link']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lodge Complaint Link</label>
                <input type="text" name="lodge_complaint_link" class="form-control"
                    value="<?= old('lodge_complaint_link', $settings['lodge_complaint_link']) ?>" required>
            </div>

            <h6 class="border-bottom pb-2 mb-3 mt-4">Footer Configuration</h6>
            <div class="mb-3">
                <label class="form-label">Footer Address (HTML allowed)</label>
                <textarea name="footer_address" class="form-control"
                    rows="3"><?= old('footer_address', $settings['footer_address'] ?? $settings['address']) ?></textarea>
                <small class="text-muted d-block">Use &lt;br&gt; for line breaks. If empty, main address will be
                    used.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Copyright Text</label>
                <input type="text" name="copyright_text" class="form-control"
                    value="<?= old('copyright_text', $settings['copyright_text'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">RBI Guidelines Text</label>
                <input type="text" name="rbi_guidelines_text" class="form-control"
                    value="<?= old('rbi_guidelines_text', $settings['rbi_guidelines_text'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">RBI Guidelines Link</label>
                <input type="url" name="rbi_guidelines_link" class="form-control"
                    value="<?= old('rbi_guidelines_link', $settings['rbi_guidelines_link'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Bank Type Text</label>
                <input type="text" name="bank_type_text" class="form-control"
                    value="<?= old('bank_type_text', $settings['bank_type_text'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Settings</button>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>