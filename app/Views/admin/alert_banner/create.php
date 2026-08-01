<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Add Alert Banner</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/alert-banner/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Banner Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
                <small class="text-muted">Recommended size: 1200x300px</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Title (optional)</label>
                <input type="text" name="title" class="form-control" placeholder="e.g., Security Alert">
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Short description"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Display as Popup?</label>
                    <select name="is_popup" class="form-control">
                        <option value="0">No (inline banner)</option>
                        <option value="1">Yes (modal popup)</option>
                    </select>
                    <small class="text-muted">Popup will appear once per session.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Banner</button>
            <a href="<?= base_url('admin/alert-banner') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>