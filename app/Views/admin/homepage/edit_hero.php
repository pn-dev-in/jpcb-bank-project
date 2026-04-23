<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Hero Section</h5>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/homepage/update-hero') ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Badge Text</label>
                    <input type="text" class="form-control" name="badge_text" value="<?= old('badge_text', $hero['badge_text']) ?>" required>
                    <small class="text-muted">Example: "Multi-State Scheduled Bank • Serving Since 1933"</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Heading Main (first line)</label>
                    <input type="text" class="form-control" name="heading_main" value="<?= old('heading_main', $hero['heading_main']) ?>" required>
                    <small class="text-muted">Example: "Banking you can trust."</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Heading Highlight (second line, primary color)</label>
                    <input type="text" class="form-control" name="heading_highlight" value="<?= old('heading_highlight', $hero['heading_highlight']) ?>" required>
                    <small class="text-muted">Example: "Service that feels human."</small>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required><?= old('description', $hero['description']) ?></textarea>
                    <small class="text-muted">Main paragraph under the heading.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button 1 Text</label>
                    <input type="text" class="form-control" name="button1_text" value="<?= old('button1_text', $hero['button1_text']) ?>" required>
                    <small class="text-muted">Example: "Explore Products"</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button 1 Link (relative URL)</label>
                    <input type="text" class="form-control" name="button1_link" value="<?= old('button1_link', $hero['button1_link']) ?>" required>
                    <small class="text-muted">Example: "deposits"</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button 2 Text</label>
                    <input type="text" class="form-control" name="button2_text" value="<?= old('button2_text', $hero['button2_text']) ?>" required>
                    <small class="text-muted">Example: "Find Branch / ATM"</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button 2 Link</label>
                    <input type="text" class="form-control" name="button2_link" value="<?= old('button2_link', $hero['button2_link']) ?>" required>
                    <small class="text-muted">Example: "about/branches"</small>
                </div>

                <div class="col-12">
                    <label class="form-label">Search Placeholder</label>
                    <input type="text" class="form-control" name="search_placeholder" value="<?= old('search_placeholder', $hero['search_placeholder']) ?>" required>
                    <small class="text-muted">Example: "Search products, forms, rates, branch..."</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Hero</button>
                <a href="<?= base_url('admin/homepage') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>