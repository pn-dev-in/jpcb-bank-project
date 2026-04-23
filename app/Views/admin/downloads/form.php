<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Upload' ?> Document</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/downloads/update/'.$item['id']) : base_url('admin/downloads/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
                <small class="text-muted d-block">Example: "Account Opening Form", "Annual Report 2024-25"</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Forms" <?= (isset($item) && $item['category'] == 'Forms') ? 'selected' : '' ?>>Forms</option>
                    <option value="Policies" <?= (isset($item) && $item['category'] == 'Policies') ? 'selected' : '' ?>>Policies</option>
                    <option value="Reports" <?= (isset($item) && $item['category'] == 'Reports') ? 'selected' : '' ?>>Reports</option>
                    <option value="Notices" <?= (isset($item) && $item['category'] == 'Notices') ? 'selected' : '' ?>>Notices</option>
                    <option value="Secured Assets" <?= (isset($item) && $item['category'] == 'Secured Assets') ? 'selected' : '' ?>>Secured Assets</option>
                </select>
                <small class="text-muted d-block">Choose the appropriate category for the document.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Document File <?= isset($item) ? '(optional, leave empty to keep current file)' : '*' ?></label>
                <?php if (isset($item) && !empty($item['file_path'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="text-primary">Current file: <?= basename($item['file_path']) ?></a>
                        <p class="text-muted small mt-1">Upload a new file to replace it.</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" <?= !isset($item) ? 'required' : '' ?>>
                <small class="text-muted d-block">Allowed types: PDF, DOC, DOCX, XLS, XLSX. Max size: 10MB.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                    <small class="text-muted d-block">Lower numbers appear first.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <small class="text-muted d-block">Inactive documents will not appear on the frontend.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($item) ? 'Update' : 'Upload' ?></button>
            <a href="<?= base_url('admin/downloads') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>