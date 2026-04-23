<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Ticker Message</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($item) ? base_url('admin/ticker/update/'.$item['id']) : base_url('admin/ticker/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="3" required placeholder="e.g., New FD rates effective from 01 Apr 2026"><?= old('message', $item['message'] ?? '') ?></textarea>
                <small class="text-muted d-block">This text will scroll across the top of the homepage.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($item) && $item['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($item) && $item['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
                <small class="text-muted d-block">Only active messages will appear on the website.</small>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($item) ? 'Update' : 'Save' ?></button>
            <a href="<?= base_url('admin/ticker') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>