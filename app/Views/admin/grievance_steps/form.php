<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($step) ? 'Edit' : 'Add' ?> Grievance Step</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($step) ? site_url('admin/grievance-steps/update/'.$step['id']) : site_url('admin/grievance-steps/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Step Number</label>
                    <input type="number" name="step" class="form-control" value="<?= old('step', $step['step'] ?? '') ?>" required placeholder="e.g., 1, 2, 3">
                    <small class="text-muted d-block">Order in which the step appears.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icon (Lucide name)</label>
                    <input type="text" name="icon" class="form-control" value="<?= old('icon', $step['icon'] ?? '') ?>" required placeholder="e.g., headphones, user-check, building">
                    <small class="text-muted d-block">Choose from <a href="https://lucide.dev/icons/" target="_blank">Lucide icons</a>.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $step['title'] ?? '') ?>" required placeholder="e.g., Contact Bank Support">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required placeholder="Explain what the user should do at this step."><?= old('description', $step['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Timeline (e.g., Response within 7–15 days)</label>
                <input type="text" name="timeline" class="form-control" value="<?= old('timeline', $step['timeline'] ?? '') ?>" required placeholder="e.g., Response within 7 working days">
                <small class="text-muted d-block">Expected resolution timeframe.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Action Button Text</label>
                    <input type="text" name="action" class="form-control" value="<?= old('action', $step['action'] ?? '') ?>" required placeholder="e.g., Call Helpline, Email Officer">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Link (URL)</label>
                    <input type="text" name="href" class="form-control" value="<?= old('href', $step['href'] ?? '') ?>" required placeholder="tel:02572220055, mailto:grievance@jpcb.in, https://cms.rbi.org.in">
                    <small class="text-muted d-block">Absolute or relative URL.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">External Link?</label>
                <select name="external" class="form-control">
                    <option value="0" <?= (isset($step) && $step['external']==0) ? 'selected' : '' ?>>No (internal)</option>
                    <option value="1" <?= (isset($step) && $step['external']==1) ? 'selected' : '' ?>>Yes (opens new tab)</option>
                </select>
                <small class="text-muted d-block">Select "Yes" for external websites (e.g., RBI portal).</small>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($step) ? 'Update' : 'Create' ?></button>
            <a href="<?= site_url('admin/grievance-steps') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>