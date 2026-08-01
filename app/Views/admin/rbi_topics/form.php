<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> RBI Topic</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/rbi-topics/update/'.$item['id']) : base_url('admin/rbi-topics/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Icon (Lucide name)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $item['icon'] ?? '') ?>" required>
                <small class="text-muted d-block">Examples: file-text, users, book-open, shield, alert-triangle</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2" required><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Link (relative URL)</label>
                <input type="text" name="href" class="form-control" value="<?= old('href', $item['href'] ?? '') ?>" required>
                <small class="text-muted d-block">Example: /rbi/fair-practice</small>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/rbi-topics') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>