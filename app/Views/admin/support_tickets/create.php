<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-2">
                    <i class="fas fa-headset text-success"></i>
                </div>
                <div>
                    <h5 class="mb-0">Create Support Ticket</h5>
                    <small class="text-muted">This will be sent to JBB Technologies support team</small>
                </div>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger border-0 rounded-3">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php foreach (session('errors') as $e): ?>
                            <div><?= esc($e) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin/support-tickets/store') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Subject <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="subject" class="form-control form-control-lg rounded-3" 
                               value="<?= old('subject') ?>" required
                               placeholder="Briefly describe your issue...">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Priority Level <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-2">
                                <?php 
                                $priorities = [
                                    'low' => ['icon' => 'arrow-down', 'color' => 'secondary', 'label' => 'Low'],
                                    'medium' => ['icon' => 'minus', 'color' => 'primary', 'label' => 'Medium'],
                                    'high' => ['icon' => 'arrow-up', 'color' => 'warning', 'label' => 'High'],
                                    'critical' => ['icon' => 'exclamation', 'color' => 'danger', 'label' => 'Critical'],
                                ];
                                foreach ($priorities as $val => $p): 
                                ?>
                                <div class="form-check">
                                    <input type="radio" name="priority" value="<?= $val ?>" 
                                           id="priority-<?= $val ?>" class="form-check-input"
                                           <?= ($val == 'medium') ? 'checked' : '' ?>>
                                    <label class="form-check-label badge bg-<?= $p['color'] ?> bg-opacity-10 text-<?= $p['color'] ?> px-3 py-2 rounded-pill" 
                                           for="priority-<?= $val ?>" style="cursor:pointer;">
                                        <i class="fas fa-<?= $p['icon'] ?> me-1"></i> <?= $p['label'] ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" class="form-control rounded-3" rows="6" required
                                  placeholder="Describe your issue in detail. Include steps to reproduce, error messages, or screenshots description..."
                                  style="resize: vertical;"><?= old('description') ?></textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end border-top pt-3">
                        <a href="<?= base_url('admin/support-tickets') ?>" class="btn btn-light rounded-pill px-4">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fas fa-paper-plane me-2"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>