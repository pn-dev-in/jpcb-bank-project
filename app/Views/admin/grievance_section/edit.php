<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Edit Grievance Redressal Section</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/grievance-section/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" name="heading" class="form-control" value="<?= old('heading', $settings['heading']) ?>" required placeholder="e.g., Grievance Redressal">
                <small class="text-muted d-block">Main title of the section.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Subheading / Description</label>
                <textarea name="subheading" class="form-control" rows="3" required placeholder="We are committed to resolving your complaints fairly and promptly..."><?= old('subheading', $settings['subheading']) ?></textarea>
                <small class="text-muted d-block">Introductory text below the heading.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Section</button>
            <a href="<?= site_url('admin/grievance-steps') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>