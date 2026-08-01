<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> UPI Linking Step</h3>
    </div>
    <div class="card-body">
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= isset($item) ? base_url('admin/upi-linking-steps/update/'.$item['id']) : base_url('admin/upi-linking-steps/store') ?>">
            <?= csrf_field() ?>

            <!-- Tab & Section (NEW) -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tab</label>
                    <select name="tab" class="form-control" required>
                        <option value="eligibility" <?= old('tab', $item['tab'] ?? '') == 'eligibility' ? 'selected' : '' ?>>Eligibility</option>
                        <option value="transactions" <?= old('tab', $item['tab'] ?? '') == 'transactions' ? 'selected' : '' ?>>Transactions</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Section</label>
                    <select name="section" class="form-control" required>
                        <!-- Eligibility sections -->
                        <optgroup label="Eligibility">
                            <option value="registration" <?= old('section', $item['section'] ?? '') == 'registration' ? 'selected' : '' ?>>Registration</option>
                            <option value="pin_generation" <?= old('section', $item['section'] ?? '') == 'pin_generation' ? 'selected' : '' ?>>PIN Generation</option>
                        </optgroup>
                        <!-- Transactions sections -->
                        <optgroup label="Transactions">
                            <option value="push" <?= old('section', $item['section'] ?? '') == 'push' ? 'selected' : '' ?>>PUSH Steps</option>
                            <option value="pull" <?= old('section', $item['section'] ?? '') == 'pull' ? 'selected' : '' ?>>PULL Steps</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Step Number</label>
                <input type="text" name="step_number" class="form-control" value="<?= old('step_number', $item['step_number'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"><?= old('description', $item['description'] ?? '') ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= old('sort_order', $item['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= (old('status', $item['status'] ?? '1') == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (old('status', $item['status'] ?? '1') == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/upi-linking-steps') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>