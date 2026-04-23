<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-<?= isset($card) ? 'edit' : 'plus' ?>"></i> <?= isset($card) ? 'Edit' : 'Add' ?> Trust Card</h5>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= isset($card) ? site_url('admin/homepage/update-card/'.$card['id']) : site_url('admin/homepage/store-card') ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Icon Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="icon_name" value="<?= old('icon_name', $card['icon_name'] ?? '') ?>" required>
                    <small class="text-muted">Lucide icon name (e.g., landmark, hand-coins, smartphone, shield)</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" value="<?= old('title', $card['title'] ?? '') ?>" required>
                    <small class="text-muted">Example: "Deposits", "Loans", "Digital Payments"</small>
                </div>

                <div class="col-12">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="description" value="<?= old('description', $card['description'] ?? '') ?>" required>
                    <small class="text-muted">Example: "FD rates up to 7.5% p.a."</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Link (optional)</label>
                    <input type="text" class="form-control" name="link" value="<?= old('link', $card['link'] ?? '') ?>">
                    <small class="text-muted">e.g., "deposits/overview" (relative URL)</small>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="<?= old('sort_order', $card['sort_order'] ?? 0) ?>">
                    <small class="text-muted">Lower = appears first</small>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="1" <?= (isset($card) && $card['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($card) && $card['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <small class="text-muted">Inactive cards won't appear on the website.</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?= isset($card) ? 'Update' : 'Create' ?></button>
                <a href="<?= site_url('admin/homepage/trust-cards') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>