<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Products Section Heading & Subheading</h3>
    </div>
    <div class="card-body">
        <form method="post" action="<?= site_url('admin/products-section/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required placeholder="e.g., Our Products & Services">
                <small class="text-muted d-block">Main title of the products section.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Subheading</label>
                <textarea name="subheading" class="form-control" rows="3" required placeholder="Comprehensive banking solutions for individuals, farmers, and businesses. Trusted by generations."><?= old('subheading', $settings['subheading']) ?></textarea>
                <small class="text-muted d-block">Introductory text below the heading.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>