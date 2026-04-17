<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($item) ? 'Edit' : 'Add' ?> Gallery Category</h2>
<form method="post" action="<?= isset($item) ? base_url('admin/gallery-categories/update/'.$item['id']) : base_url('admin/gallery-categories/store') ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Slug (leave empty to auto-generate)</label>
        <input type="text" name="slug" class="form-control" value="<?= old('slug', $item['slug'] ?? '') ?>">
        <small>Example: events, awards, branch-activities</small>
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
    <a href="<?= base_url('admin/gallery-categories') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>