<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<h2><?= isset($link) ? 'Edit' : 'Add' ?> Social Link</h2>
<form method="post" action="<?= isset($link) ? site_url('admin/social-links/update/'.$link['id']) : site_url('admin/social-links/store') ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Platform Name</label>
        <input type="text" name="platform" class="form-control" value="<?= old('platform', $link['platform'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Icon (Lucide name)</label>
        <input type="text" name="icon" class="form-control" value="<?= old('icon', $link['icon'] ?? '') ?>" required>
        <small>e.g., facebook, twitter, linkedin, youtube, instagram</small>
    </div>
    <div class="form-group">
        <label>URL</label>
        <input type="url" name="url" class="form-control" value="<?= old('url', $link['url'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $link['sort_order'] ?? 0) ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" <?= (isset($link) && $link['status']==1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($link) && $link['status']==0) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
<?= $this->endSection() ?>