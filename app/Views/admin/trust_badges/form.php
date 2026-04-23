<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($badge) ? 'Edit' : 'Add' ?> Trust Badge</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($badge) ? site_url('admin/trust-badges/update/'.$badge['id']) : site_url('admin/trust-badges/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Icon Name (Lucide icon)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $badge['icon'] ?? '') ?>" required>
                <small class="text-muted d-block">Examples: shield, award, heart, building, hand-coins, etc.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Label (text to display)</label>
                <input type="text" name="label" class="form-control" value="<?= old('label', $badge['label'] ?? '') ?>" required>
                <small class="text-muted d-block">Examples: RBI Regulated, Scheduled Bank, DICGC Insured, Accessible Banking</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Color Class (optional)</label>
                    <select name="color_class" class="form-control">
                        <option value="" <?= (isset($badge) && empty($badge['color_class'])) ? 'selected' : '' ?>>Default (primary)</option>
                        <option value="primary" <?= (isset($badge) && $badge['color_class'] == 'primary') ? 'selected' : '' ?>>Primary</option>
                        <option value="secondary" <?= (isset($badge) && $badge['color_class'] == 'secondary') ? 'selected' : '' ?>>Secondary</option>
                        <option value="destructive" <?= (isset($badge) && $badge['color_class'] == 'destructive') ? 'selected' : '' ?>>Destructive</option>
                    </select>
                    <small class="text-muted d-block">Affects icon color in frontend. Leave empty for primary.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order (lower = appears first)</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $badge['sort_order'] ?? 0) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($badge) && $badge['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($badge) && $badge['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($badge) ? 'Update' : 'Create' ?></button>
            <a href="<?= site_url('admin/trust-badges') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>