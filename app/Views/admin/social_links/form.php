<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($link) ? 'Edit' : 'Add' ?> Social Link</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($link) ? site_url('admin/social-links/update/'.$link['id']) : site_url('admin/social-links/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Platform Name</label>
                <input type="text" name="platform" class="form-control" value="<?= old('platform', $link['platform'] ?? '') ?>" required>
                <small class="text-muted d-block">Example: Facebook, Twitter, LinkedIn, YouTube</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Icon (Lucide name)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $link['icon'] ?? '') ?>" required>
                <small class="text-muted d-block">e.g., facebook, twitter, linkedin, youtube, instagram</small>
            </div>
            <div class="mb-3">
                <label class="form-label">URL</label>
                <input type="url" name="url" class="form-control" value="<?= old('url', $link['url'] ?? '') ?>" required>
                <small class="text-muted d-block">Full URL including https://</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $link['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($link) && $link['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($link) && $link['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= site_url('admin/social-links') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>