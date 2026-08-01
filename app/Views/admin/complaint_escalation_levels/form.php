<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Escalation Level</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/complaint-escalation-levels/update/'.$item['id']) : base_url('admin/complaint-escalation-levels/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Level (e.g., Level 1)</label>
                <input type="text" name="level" class="form-control" value="<?= old('level', $item['level'] ?? '') ?>" required>
                <small class="text-muted d-block">Example: Level 1, Level 2, etc.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Title (e.g., Branch Manager)</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Name of Contact Person</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $item['name'] ?? '') ?>">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= old('phone', $item['phone'] ?? '') ?>">
                    <small class="text-muted d-block">e.g., 0257-2220055 or "Visit branch"</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $item['email'] ?? '') ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Timeline (e.g., 7 working days)</label>
                <input type="text" name="timeline" class="form-control" value="<?= old('timeline', $item['timeline'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"><?= old('description', $item['description'] ?? '') ?></textarea>
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
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/complaint-escalation-levels') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>