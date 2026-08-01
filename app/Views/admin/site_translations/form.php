<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<?php $isEdit = isset($item); ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= $isEdit ? 'Edit' : 'Add' ?> Translation</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= $isEdit ? base_url('admin/site-translations/update/' . $item['id']) : base_url('admin/site-translations/store') ?>">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Language</label>
                    <?php if ($isEdit): ?>
                        <input type="text" class="form-control" value="<?= esc(($item['language'] ?? '') === 'mr' ? 'Marathi' : 'Hindi') ?>" disabled>
                    <?php else: ?>
                        <select name="language" class="form-control" required>
                            <option value="hi" <?= old('language') === 'hi' ? 'selected' : '' ?>>Hindi</option>
                            <option value="mr" <?= old('language') === 'mr' ? 'selected' : '' ?>>Marathi</option>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Context</label>
                    <input type="text" name="context" class="form-control" value="<?= old('context', $item['context'] ?? '') ?>" placeholder="Header, footer, about page...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (int) old('status', $item['status'] ?? 1) === 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (int) old('status', $item['status'] ?? 1) === 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">English Source Text</label>
                <textarea name="source_text" class="form-control" rows="3" <?= $isEdit ? 'readonly' : 'required' ?>><?= old('source_text', $item['source_text'] ?? '') ?></textarea>
                <small class="text-muted">Keep this exactly as it appears on the website.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Meaningful Translation</label>
                <textarea name="translation" class="form-control" rows="4" required><?= old('translation', $item['translation'] ?? '') ?></textarea>
                <small class="text-muted">Use reviewed banking language, not literal word-by-word translation.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/site-translations') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
