<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Milestone</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/about-milestones/update/'.$item['id']) : base_url('admin/about-milestones/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Year</label>
                    <input type="text" name="year" class="form-control" value="<?= old('year', $item['year'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/about-milestones') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>