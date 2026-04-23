<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-home"></i> Homepage CMS</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <!-- Hero Section Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-edit fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Hero Section</h5>
                                <small class="text-muted">Edit heading, subheading, buttons</small>
                            </div>
                        </div>
                        <a href="<?= base_url('admin/homepage/edit-hero') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-edit"></i> Edit Hero
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trust Cards Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-cards fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Trust Cards</h5>
                                <small class="text-muted">Manage cards shown on homepage</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('admin/homepage/trust-cards') ?>" class="btn btn-outline-primary flex-fill">
                                <i class="fas fa-list"></i> View Cards
                            </a>
                            <a href="<?= base_url('admin/homepage/create-card') ?>" class="btn btn-primary flex-fill">
                                <i class="fas fa-plus"></i> Add New Card
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>