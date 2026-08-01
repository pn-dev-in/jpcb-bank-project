<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><?= isset($item) ? 'Edit' : 'Add' ?> Ombudsman Officer</h3>
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

        <form method="post" action="<?= isset($item) ? base_url('admin/rbi-ombudsman-officers/update/'.$item['id']) : base_url('admin/rbi-ombudsman-officers/store') ?>">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title', $item['title'] ?? '') ?>">
                    <small class="text-muted">e.g., "Grievance Redressal Officer" or "The Banking Ombudsman"</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Officer Name</label>
                    <input type="text" name="officer_name" class="form-control" value="<?= old('officer_name', $item['officer_name'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Designation</label>
                <input type="text" name="designation" class="form-control" value="<?= old('designation', $item['designation'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Office Address</label>
                <textarea name="office_address" class="form-control" rows="4"><?= old('office_address', $item['office_address'] ?? '') ?></textarea>
                <small class="text-muted">Line breaks will be preserved on the frontend.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= old('phone', $item['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fax</label>
                    <input type="text" name="fax" class="form-control" value="<?= old('fax', $item['fax'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $item['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Website</label>
                    <input type="text" name="website" class="form-control" value="<?= old('website', $item['website'] ?? '') ?>">
                </div>
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
            <a href="<?= base_url('admin/rbi-ombudsman-officers') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>