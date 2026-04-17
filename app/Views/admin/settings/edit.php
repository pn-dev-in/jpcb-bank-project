<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>General Settings & Header/Footer Configuration</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach(session()->getFlashdata('errors') as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/settings/update') ?>">
    <?= csrf_field() ?>

    <!-- General -->
    <div class="form-group">
        <label>Site Name</label>
        <input type="text" name="site_name" class="form-control" value="<?= old('site_name', $settings['site_name']) ?>" required>
    </div>

    <div class="form-group">
        <label>Phone Number (display format)</label>
        <input type="text" name="phone" class="form-control" value="<?= old('phone', $settings['phone']) ?>" required>
        <small>Example: 0257-2220055</small>
    </div>

    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= old('email', $settings['email']) ?>" required>
    </div>

    <div class="form-group">
        <label>Business Hours</label>
        <input type="text" name="business_hours" class="form-control" value="<?= old('business_hours', $settings['business_hours']) ?>" required>
        <small>Example: Mon-Sat: 10:00 AM - 4:00 PM</small>
    </div>

    <div class="form-group">
        <label>Address (footer fallback)</label>
        <textarea name="address" class="form-control" rows="2"><?= old('address', $settings['address']) ?></textarea>
    </div>

    <hr>

    <h3>Header Links Configuration</h3>

    <div class="form-group">
        <label>Digital Banking Button Text</label>
        <input type="text" name="digital_banking_button_text" class="form-control" value="<?= old('digital_banking_button_text', $settings['digital_banking_button_text']) ?>" required>
    </div>

    <div class="form-group">
        <label>Digital Banking Link</label>
        <input type="text" name="digital_banking_link" class="form-control" value="<?= old('digital_banking_link', $settings['digital_banking_link']) ?>" required>
        <small>Relative URL: digital/mobile-banking</small>
    </div>

    <div class="form-group">
        <label>Locate Branch Link</label>
        <input type="text" name="locate_branch_link" class="form-control" value="<?= old('locate_branch_link', $settings['locate_branch_link']) ?>" required>
    </div>

    <div class="form-group">
        <label>Block ATM Card Link</label>
        <input type="text" name="block_card_link" class="form-control" value="<?= old('block_card_link', $settings['block_card_link']) ?>" required>
    </div>

    <div class="form-group">
        <label>Lodge Complaint Link</label>
        <input type="text" name="lodge_complaint_link" class="form-control" value="<?= old('lodge_complaint_link', $settings['lodge_complaint_link']) ?>" required>
    </div>

    <hr>

    <h3>Footer Configuration</h3>

    <div class="form-group">
        <label>Footer Address (HTML allowed)</label>
        <textarea name="footer_address" class="form-control" rows="3"><?= old('footer_address', $settings['footer_address'] ?? $settings['address']) ?></textarea>
        <small>Use &lt;br&gt; for line breaks. If empty, main address will be used.</small>
    </div>

    <div class="form-group">
        <label>Copyright Text</label>
        <input type="text" name="copyright_text" class="form-control" value="<?= old('copyright_text', $settings['copyright_text'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>RBI Guidelines Text</label>
        <input type="text" name="rbi_guidelines_text" class="form-control" value="<?= old('rbi_guidelines_text', $settings['rbi_guidelines_text'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>RBI Guidelines Link</label>
        <input type="url" name="rbi_guidelines_link" class="form-control" value="<?= old('rbi_guidelines_link', $settings['rbi_guidelines_link'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Bank Type Text</label>
        <input type="text" name="bank_type_text" class="form-control" value="<?= old('bank_type_text', $settings['bank_type_text'] ?? '') ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update Settings</button>
</form>

<?= $this->endSection() ?>