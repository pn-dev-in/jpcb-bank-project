<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Service Section Settings</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/service-settings/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Locker Eligibility List (one per line)</label>
                <textarea name="locker_eligibility_list" class="form-control" rows="8"><?= esc($settings['locker_eligibility_list'] ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point in the lockers page.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Required Fields (one per line)</label>
                <textarea name="positive_pay_fields" class="form-control" rows="8"><?= esc($settings['positive_pay_fields'] ?? '') ?></textarea>
                <small class="text-muted d-block">Fields displayed under "Details Required for Submission".</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Submission Methods (JSON array)</label>
                <textarea name="positive_pay_submission_methods" class="form-control" rows="6"><?= esc($settings['positive_pay_submission_methods'] ?? '') ?></textarea>
                <small class="text-muted d-block">Example: [{"title":"Mobile Banking App","desc":"Go to Services → Positive Pay → Enter cheque details → Submit."}]</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Positive Pay Important Note</label>
                <textarea name="positive_pay_important_note" class="form-control" rows="4"><?= esc($settings['positive_pay_important_note'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="<?= base_url('admin/service-cards') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>