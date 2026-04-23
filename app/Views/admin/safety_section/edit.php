<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Safety Section (Fraud Awareness)</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/safety-section/update') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required>
                <small class="text-muted d-block">Example: "Stay Safe from Fraud"</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Warning Text (highlighted box)</label>
                <textarea name="warning_text" class="form-control" rows="3" required placeholder="⚠️ We NEVER ask for OTP, PIN, or Password over call, SMS, or email."><?= old('warning_text', $settings['warning_text']) ?></textarea>
                <small class="text-muted d-block">This appears in a highlighted red box.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (main paragraph)</label>
                <textarea name="description" class="form-control" rows="4" required placeholder="Beware of phishing websites, fake calls, and fraudulent messages. Do not share your card details..."><?= old('description', $settings['description']) ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Button 1 Text</label>
                    <input type="text" name="button1_text" class="form-control" value="<?= old('button1_text', $settings['button1_text']) ?>" required>
                    <small class="text-muted d-block">Example: "Safety Tips"</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button 1 Link (relative or absolute)</label>
                    <input type="text" name="button1_link" class="form-control" value="<?= old('button1_link', $settings['button1_link']) ?>" required>
                    <small class="text-muted d-block">Example: "rbi/dos-and-donts" or "https://example.com"</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Button 2 Text</label>
                    <input type="text" name="button2_text" class="form-control" value="<?= old('button2_text', $settings['button2_text']) ?>" required>
                    <small class="text-muted d-block">Example: "Report Fraud: 0257-2220055"</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button 2 Link (e.g., tel:number)</label>
                    <input type="text" name="button2_link" class="form-control" value="<?= old('button2_link', $settings['button2_link']) ?>" required>
                    <small class="text-muted d-block">Example: "tel:02572220055"</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Button 3 Text</label>
                    <input type="text" name="button3_text" class="form-control" value="<?= old('button3_text', $settings['button3_text']) ?>" required>
                    <small class="text-muted d-block">Example: "Report Online"</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button 3 Link (external URL)</label>
                    <input type="text" name="button3_link" class="form-control" value="<?= old('button3_link', $settings['button3_link']) ?>" required>
                    <small class="text-muted d-block">Example: "https://cybercrime.gov.in"</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Section</button>
            <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>