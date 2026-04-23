<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($notice) ? 'Edit' : 'Add' ?> Notice</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($notice) ? base_url('admin/notices/update/'.$notice['id']) : base_url('admin/notices/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $notice['title'] ?? '') ?>" required placeholder="e.g., Holiday notice for Gudi Padwa">
                <small class="text-muted d-block">Clear, descriptive title of the notice.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Additional details about the notice (optional)"><?= old('description', $notice['description'] ?? '') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="Announcement" <?= (isset($notice) && $notice['type'] == 'Announcement') ? 'selected' : '' ?>>Announcement</option>
                        <option value="Alert" <?= (isset($notice) && $notice['type'] == 'Alert') ? 'selected' : '' ?>>Alert</option>
                        <option value="Holiday" <?= (isset($notice) && $notice['type'] == 'Holiday') ? 'selected' : '' ?>>Holiday</option>
                    </select>
                    <small class="text-muted d-block">Choose the appropriate category.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control" value="<?= old('date', $notice['date'] ?? date('Y-m-d')) ?>" required>
                    <small class="text-muted d-block">Effective date of the notice.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($notice) ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('admin/notices') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>