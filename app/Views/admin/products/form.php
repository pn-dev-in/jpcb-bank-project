<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($product) ? 'Edit' : 'Add' ?> Product</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= isset($product) ? site_url('admin/products/update/'.$product['id']) : site_url('admin/products/store') ?>">
            <?= csrf_field() ?>

            <!-- Basic Information -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" required>
                    <small class="text-muted">e.g., Savings Account, Fixed Deposit, Gold Loan</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icon Name <span class="text-danger">*</span></label>
                    <input type="text" name="icon" class="form-control" value="<?= old('icon', $product['icon'] ?? '') ?>" required>
                    <small class="text-muted">Lucide icon: <a href="https://lucide.dev/icons/" target="_blank">View icons</a></small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?= old('category', $product['category'] ?? '') ?>">
                    <small class="text-muted">e.g., savings, loan, agri, digital</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Link URL <span class="text-danger">*</span></label>
                    <input type="text" name="href" class="form-control" value="<?= old('href', $product['href'] ?? '') ?>" required>
                    <small class="text-muted">e.g., /savings, /loans/products</small>
                </div>
            </div>

            <!-- Sort Order & Status -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $product['sort_order'] ?? 0) ?>">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (isset($product) && $product['status']==1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($product) && $product['status']==0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Features -->
            <div class="mb-3">
                <label class="form-label">Features <span class="text-danger">*</span> (one per line)</label>
                <textarea name="features" class="form-control" rows="4" required><?= old('features', $featuresText ?? '') ?></textarea>
                <small class="text-muted">Each line becomes a bullet point on the product card</small>
            </div>

            <!-- Intro Text -->
            <div class="mb-3">
                <label class="form-label">Intro Text (Short Description)</label>
                <textarea name="intro" class="form-control" rows="3" placeholder="Brief description of the product"><?= old('intro', $product['intro'] ?? '') ?></textarea>
                <small class="text-muted">Appears in the expanded panel. Keep it concise (1-2 sentences).</small>
            </div>

            <!-- Benefits (Expandable Panel) -->
            <div class="mb-3">
                <label class="form-label">Benefits (one per line)</label>
                <textarea name="benefits" class="form-control" rows="4" placeholder="Higher interest rates for senior citizens&#10;Loan against FD facility&#10;Auto-renewal option available"><?php 
                    if (isset($benefitsArray) && !empty($benefitsArray)) {
                        echo implode("\n", $benefitsArray);
                    } else {
                        echo old('benefits', $product['benefits'] ?? '');
                    }
                ?></textarea>
                <small class="text-muted">Key benefits that appear in the expanded panel</small>
            </div>

            <!-- CTA Buttons -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Apply Now Link (CTA)</label>
                    <input type="text" name="cta_apply" class="form-control" value="<?= old('cta_apply', $product['cta_apply'] ?? '') ?>" placeholder="/apply/product-name">
                    <small class="text-muted">URL for the primary "Apply Now" button</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">View Details Link (CTA)</label>
                    <input type="text" name="cta_details" class="form-control" value="<?= old('cta_details', $product['cta_details'] ?? '') ?>" placeholder="/product-details">
                    <small class="text-muted">URL for the secondary "View Details" button</small>
                </div>
            </div>

            <!-- Target & Image Alt -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Link Target</label>
                    <select name="cta_target" class="form-control">
                        <option value="_self" <?= (isset($product) && ($product['cta_target'] ?? '_self') == '_self') ? 'selected' : '' ?>>Same Window (_self)</option>
                        <option value="_blank" <?= (isset($product) && ($product['cta_target'] ?? '') == '_blank') ? 'selected' : '' ?>>New Window (_blank)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image Alt Text (optional)</label>
                    <input type="text" name="image_alt" class="form-control" value="<?= old('image_alt', $product['image_alt'] ?? '') ?>" placeholder="Product image description">
                    <small class="text-muted">For SEO and accessibility</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update Product' : 'Create Product' ?></button>
            <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>