<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> DigiSaathi Contact</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/digisaathi-contacts/update/'.$item['id']) : base_url('admin/digisaathi-contacts/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Icon (Lucide name)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $item['icon'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subtitle (optional)</label>
                <input type="text" name="subtitle" class="form-control" value="<?= old('subtitle', $item['subtitle'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Link (URL)</label>
                <input type="text" name="link" class="form-control" value="<?= old('link', $item['link'] ?? '') ?>" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Is External?</label>
                    <select name="is_external" class="form-control">
                        <option value="0" <?= (isset($item) && $item['is_external']==0) ? 'selected' : '' ?>>No (internal)</option>
                        <option value="1" <?= (isset($item) && $item['is_external']==1) ? 'selected' : '' ?>>Yes (opens new tab)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/digisaathi-contacts') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>