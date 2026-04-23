<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($product) ? 'Edit' : 'Add' ?> Product</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($product) ? site_url('admin/products/update/'.$product['id']) : site_url('admin/products/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" required placeholder="e.g., Savings Account, Fixed Deposit, Gold Loan">
                <small class="text-muted d-block">Display name of the product.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Icon Name (Lucide icon)</label>
                <input type="text" name="icon" class="form-control" value="<?= old('icon', $product['icon'] ?? '') ?>" required placeholder="e.g., piggy-bank, landmark, hand-coins, tractor">
                <small class="text-muted d-block">Choose from <a href="https://lucide.dev/icons/" target="_blank">Lucide icons</a>.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Category (optional)</label>
                <input type="text" name="category" class="form-control" value="<?= old('category', $product['category'] ?? '') ?>" placeholder="e.g., savings, loan, agri, digital">
                <small class="text-muted d-block">Used for grouping (optional).</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Link (URL path)</label>
                <input type="text" name="href" class="form-control" value="<?= old('href', $product['href'] ?? '') ?>" required placeholder="e.g., deposits/overview, loans/products">
                <small class="text-muted d-block">Relative URL to the product page.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order (lower = higher)</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $product['sort_order'] ?? 0) ?>" placeholder="e.g., 1, 2, 3">
                    <small class="text-muted d-block">Determines display order.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($product) && $product['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($product) && $product['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <small class="text-muted d-block">Inactive products won't appear on the frontend.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Features (one per line)</label>
                <textarea name="features" class="form-control" rows="5" required placeholder="Zero balance options available&#10;Attractive interest rates&#10;Digital payments enabled"><?= old('features', $featuresText ?? '') ?></textarea>
                <small class="text-muted d-block">Each line becomes a bullet point.</small>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update' : 'Create' ?></button>
            <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>