<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($item) ? 'Edit' : 'Add' ?> Award</h2>
<form method="post" action="<?= isset($item) ? base_url('admin/awards/update/'.$item['id']) : base_url('admin/awards/store') ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Year</label>
        <input type="text" name="year" class="form-control" value="<?= old('year', $item['year'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Organization</label>
        <input type="text" name="organization" class="form-control" value="<?= old('organization', $item['organization'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3" required><?= old('description', $item['description'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= base_url('admin/awards') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>