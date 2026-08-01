<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Elite Account</h3>
    </div>
    <div class="card-body">
        <form method="post"
            action="<?= isset($item) ? base_url('admin/elite-accounts/update/' . $item['id']) : base_url('admin/elite-accounts/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Badge Text</label>
                    <input type="text" name="badge_text" class="form-control" value="<?= old('badge_text', $item['badge_text'] ?? 'Premium Banking') ?>">
                    <small class="text-muted">e.g., Premium Banking, Elite, Exclusive</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Badge Icon (Lucide)</label>
                    <input type="text" name="badge_icon" class="form-control" value="<?= old('badge_icon', $item['badge_icon'] ?? 'crown') ?>">
                    <small class="text-muted">Lucide icon name, e.g., crown, star, diamond</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Heading *</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $item['heading'] ?? 'Elite Account') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description *</label>
                <textarea name="description" rows="5" class="form-control" required><?= old('description', $item['description'] ?? '') ?></textarea>
                <small class="text-muted">Detailed description of the elite/premium account</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Form (PDF)</label>
                <?php if (!empty($item['form_pdf'])): ?>
                    <div class="mb-2">
                        <a href="<?= base_url($item['form_pdf']) ?>" target="_blank">View current form</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="form_pdf" class="form-control" accept=".pdf">
                <small class="text-muted">Upload a PDF form for this elite account. Leave empty to keep current.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Features (one per line) *</label>
                <textarea name="features" class="form-control" rows="6" required><?= old('features', $featuresText ?? '') ?></textarea>
                <small class="text-muted">Enter each feature on a new line. e.g.,<br>
                Free Mobile Banking<br>
                Free ATM Card<br>
                Free RTGS / NEFT<br>
                Premium Banking Services</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($item) && $item['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($item) && $item['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Show in Frontend</label>
                    <select name="show_in_frontend" class="form-control">
                        <option value="1" <?= (isset($item) && $item['show_in_frontend'] == 1) ? 'selected' : '' ?>>Yes</option>
                        <option value="0" <?= (isset($item) && $item['show_in_frontend'] == 0) ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/elite-accounts') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>