<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($item) ? 'Edit' : 'Add' ?> Stat</h2>
<form method="post" action="<?= isset($item) ? base_url('admin/about-stats/update/'.$item['id']) : base_url('admin/about-stats/store') ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Number (e.g., 75+)</label>
        <input type="text" name="number" class="form-control" value="<?= old('number', $item['number'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Label (e.g., Years of Service)</label>
        <input type="text" name="label" class="form-control" value="<?= old('label', $item['label'] ?? '') ?>" required>
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
    <a href="<?= base_url('admin/about-stats') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>