<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2><?= isset($item) ? 'Edit' : 'Add' ?> Board Member</h2>
<form method="post" action="<?= isset($item) ? base_url('admin/board-members/update/'.$item['id']) : base_url('admin/board-members/store') ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Role (e.g., Chairman, Director)</label>
        <input type="text" name="role" class="form-control" value="<?= old('role', $item['role'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Category (e.g., Office Bearers, Directors)</label>
        <input type="text" name="category" class="form-control" value="<?= old('category', $item['category'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Bio (optional)</label>
        <textarea name="bio" class="form-control" rows="3"><?= old('bio', $item['bio'] ?? '') ?></textarea>
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
    <a href="<?= base_url('admin/board-members') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>