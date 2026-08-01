<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($notice) ? 'Edit' : 'Add' ?> Notice</h3>
    </div>
    <div class="card-body">
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data"
              action="<?= isset($notice) ? base_url('admin/notices/update/'.$notice['id']) : base_url('admin/notices/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= old('title', $notice['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"><?= old('description', $notice['description'] ?? '') ?></textarea>
            </div>

            <!-- PDF / file upload -->
            <div class="mb-3">
                <label class="form-label">Notice PDF / File</label>
                <?php if (!empty($notice['file_path'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($notice['file_path']) ?>" target="_blank">View current file</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="notice_file" class="form-control">
                <small class="text-muted d-block">Upload a PDF or image. Leave empty to keep the existing file.</small>
            </div>

            <!-- External link -->
            <div class="mb-3">
                <label class="form-label">External Link (optional)</label>
                <input type="url" name="external_link" class="form-control"
                       value="<?= old('external_link', $notice['external_link'] ?? '') ?>">
                <small class="text-muted d-block">A full URL (e.g., RBI circular).</small>
            </div>

            <!-- Type, Date, Sort Order, Status -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="Announcement" <?= (isset($notice) && $notice['type']=='Announcement') ? 'selected' : '' ?>>Announcement</option>
                        <option value="Alert" <?= (isset($notice) && $notice['type']=='Alert') ? 'selected' : '' ?>>Alert</option>
                        <option value="Holiday" <?= (isset($notice) && $notice['type']=='Holiday') ? 'selected' : '' ?>>Holiday</option>
                        <option value="Regulatory" <?= (isset($notice) && $notice['type']=='Regulatory') ? 'selected' : '' ?>>Regulatory</option>
                        <option value="Service Update" <?= (isset($notice) && $notice['type']=='Service Update') ? 'selected' : '' ?>>Service Update</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control" 
                           value="<?= old('date', $notice['date'] ?? date('Y-m-d')) ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" 
                           value="<?= old('sort_order', $notice['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($notice) && $notice['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($notice) && $notice['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($notice) ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('admin/notices') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>