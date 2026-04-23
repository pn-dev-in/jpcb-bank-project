<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4"><?= isset($notice) ? 'Edit' : 'Add' ?> Notice</h1>
        <a href="<?= base_url('admin/notices') ?>" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Back to Notices
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="ri-file-copy-line me-1"></i> Notice Details
        </div>
        <div class="card-body">
            <form method="post" action="<?= isset($notice) ? base_url('admin/notices/update/' . $notice['id']) : base_url('admin/notices/store') ?>">
                <?= csrf_field() ?>
                <?php if (isset($notice)): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $notice['title'] ?? '') ?>" required placeholder="e.g., New branch opening at Nashik Road">
                    <small class="text-muted d-block">Short, descriptive title.</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Detailed information about the notice (optional)"><?= old('description', $notice['description'] ?? '') ?></textarea>
                    <small class="text-muted d-block">Any additional details.</small>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type *</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="Announcement" <?= (isset($notice) && $notice['type'] == 'Announcement') ? 'selected' : '' ?>>Announcement</option>
                        <option value="Alert" <?= (isset($notice) && $notice['type'] == 'Alert') ? 'selected' : '' ?>>Alert</option>
                        <option value="Holiday" <?= (isset($notice) && $notice['type'] == 'Holiday') ? 'selected' : '' ?>>Holiday</option>
                        <option value="Regulatory" <?= (isset($notice) && $notice['type'] == 'Regulatory') ? 'selected' : '' ?>>Regulatory</option>
                        <option value="Service Update" <?= (isset($notice) && $notice['type'] == 'Service Update') ? 'selected' : '' ?>>Service Update</option>
                    </select>
                    <small class="text-muted d-block">Category of the notice.</small>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date *</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?= old('date', $notice['date'] ?? date('Y-m-d')) ?>" required>
                    <small class="text-muted d-block">When the notice becomes effective.</small>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="ri-save-line"></i> <?= isset($notice) ? 'Update' : 'Save' ?>
                </button>
                <a href="<?= base_url('admin/notices') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>