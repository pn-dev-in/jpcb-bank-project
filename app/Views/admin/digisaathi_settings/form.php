<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Setting</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/digisaathi-settings/update/'.$item['id']) : base_url('admin/digisaathi-settings/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Key</label>
                <input type="text" name="key" class="form-control" value="<?= old('key', $item['key'] ?? '') ?>" required <?= isset($item) ? 'readonly' : '' ?>>
                <small class="text-muted">Unique identifier (e.g., hero_title, about_description)</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="text" <?= (isset($item) && $item['type']=='text') ? 'selected' : '' ?>>Text</option>
                    <option value="textarea" <?= (isset($item) && $item['type']=='textarea') ? 'selected' : '' ?>>Textarea</option>
                    <option value="image" <?= (isset($item) && $item['type']=='image') ? 'selected' : '' ?>>Image</option>
                    <option value="json" <?= (isset($item) && $item['type']=='json') ? 'selected' : '' ?>>JSON</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Value</label>
                <?php if (isset($item) && $item['type'] == 'textarea'): ?>
                    <textarea name="value" class="form-control" rows="5"><?= old('value', $item['value'] ?? '') ?></textarea>
                <?php else: ?>
                    <input type="text" name="value" class="form-control" value="<?= old('value', $item['value'] ?? '') ?>">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/digisaathi-settings') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>